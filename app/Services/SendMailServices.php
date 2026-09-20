<?php

namespace App\Services;

use App\Mail\NotificacionEmail;
use App\Models\Notification;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendMailServices
{
    /**
     * Método principal para enviar emails
     */
    public function sendMail(array $data = []): bool
    {
        try {
            // Validación más completa
            if (empty($data['email'])) {
                throw new \InvalidArgumentException("El correo del destinatario es obligatorio.");
            }
            
            // Validar formato de email
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                throw new \InvalidArgumentException("El correo '{$data['email']}' no tiene un formato válido.");
            }
            
            // Asegurar que 'name' tenga un valor por defecto
            $data['name'] = $data['name'] ?: ($data['full_name'] ?: $data['email']);
            
            // Asegurar que 'subject' tenga un valor por defecto
            $data['subject'] = $data['subject'] ?? __t('text.email.template.hello_user');
            
            // Asegurar que 'message' tenga un valor por defecto
            $data['message'] = $data['message'] ?? '';
            
            // Asegurar que 'template_email' tenga un valor por defecto
            $data['template_email'] = $data['template_email'] ?? 'emails.notification';
            
            // Crear el Mailable
            $mailable = new NotificacionEmail($data);
            
            // Enviar el email
            Mail::to($data['email'])->send($mailable);
            
            // Log de éxito
            Log::info('Email enviado exitosamente', [
                'email'    => $data['email'],
                'subject'  => $data['subject'],
                'template' => $data['template_email'],
                'plan'     => $data['plan_name'] ?? 'N/A',
                'bcc'      => $data['bcc'] ?? 'N/A',
            ]);
            
            return true;
            
        } catch (\InvalidArgumentException $e) {
            // Error de validación
            Log::warning('Email no enviado - Error de validación', [
                'email' => $data['email'] ?? 'desconocido',
                'error' => $e->getMessage()
            ]);
            return false;
            
        } catch (\Exception $e) {
            // Error general
            Log::error('Error enviando email', [
                'email'   => $data['email'] ?? 'desconocido',
                'subject' => $data['subject'] ?? 'N/A',
                'error'   => $e->getMessage(),
                'trace'   => substr($e->getTraceAsString(), 0, 1000) // Limitar el tamaño del trace
            ]);
            
            return false;
        }
    }
    
    /**
     * Enviar email de registro de usuario
     */
    public function sendMailRegisterUser(array $data, User $user): bool
    {
        try {
            $templateSubject = __t('text.email.welcome.subject');
            $subject         = str_replace('[APP_NAME]', env('APP_NAME', 'LA-MANO-NEGRA'), $templateSubject);
            
            $templateText = __t('text.email.welcome.body_text');
            $templateText = str_replace(
                ['[USER_NAME]', '[USER_PASSWORD]'],
                [$data['email'], $data['password'] ?? ''],
                $templateText
            );
            
            $notification=Notification::notificationCreate([
                'user_id'   => $user->id,
                'channel'   => Notification::CHANNEL_EMAIL,
                'type'      => Notification::TYPE_WELCOME,
                'addressee' => $user->email,
                'subject'   => $subject,
                'content'   => $templateText,
            ]);
            
            return $this->sendMail([
                'name'           => $user->name ?? $user->email,
                'full_name'      => $user->first_name . ' ' . $user->last_name ?? $user->email,
                'email'          => $user->email,
                'email_encrypt'  => encrypt($user->email),
                'subject'        => $subject,
                'message'        => $templateText,
                'template_email' => 'emails.welcome',
                'tracking_token' => $notification?->tracking_token,
            ]);
            
        } catch (\Exception $e) {
            
            
            if (isset($notification) && $notification) {
                $notification->update([
                    'state'     => Notification::STATE_FAILED,
                    'error_log' => substr($e->getMessage(), 0, 2000),
                ]);
            }
            
            Log::error('Error en sendMailRegisterUser', [
                'user_id'       => $user->id ?? null,
                'user_email'    => $user->email ?? null,
                'user_name'     => $user->name ?? null,
                'tracking_token'=> $data['tracking_token'] ?? null,
                'error_message' => $e->getMessage(),
                'error_code'    => $e->getCode(),
                'error_file'    => $e->getFile(),
                'error_line'    => $e->getLine(),
                'trace'         => $e->getTraceAsString(),
            ]);
            return false;
        }
    }
    
    /**
     * Enviar email de acceso al sistema
     */
    public function sendMailAccessSystem(array $data, User $user): bool
    {
        try {
            $templateSubject = __t('text.email.update_access_system.subject');
            $subject         = str_replace('[APP_NAME]', env('APP_NAME', 'Laravel'), $templateSubject);
            
            $templateText = __t('text.email.update_access_system.body_text');
            $templateText = str_replace(
                ['[USER_NAME]', '[USER_EMAIL]', '[USER_PASSWORD]'],
                [$data['user_name'] ?? '', $data['email'] ?? '', $data['password'] ?? ''],
                $templateText
            );
            
            return $this->sendMail([
                'name'           => $user->name ?? $user->email,
                'full_name'      => $data['user_name'] ?? $user->email,
                'email'          => $user->email,
                'email_encrypt'  => encrypt($user->email),
                'subject'        => $subject,
                'message'        => $templateText,
                'template_email' => 'emails.welcome',
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en sendMailAccessSystem', [
                'user_id' => $user->id ?? null,
                'error'   => $e->getMessage()
            ]);
            return false;
        }
    }
    
    /**
     * Enviar email de recuperación de contraseña
     */
    public function sendMailRecoverPassword($user): bool
    {
        try {
            $templateSubject = __t('text.email.reset_password.subject');
            $subject         = str_replace('[APP_NAME]', env('APP_NAME', 'Laravel'), $templateSubject);
            
            $templateText = __t('text.email.reset_password.body_text');
            $templateText = str_replace('[USER_EMAIL]', $user->email, $templateText);
            
            return $this->sendMail([
                'name'           => capitalize_first($user->first_name . ' ' . $user->last_name),
                'full_name'      => capitalize_first($user->first_name . ' ' . $user->last_name),
                'email'          => $user->email,
                'email_encrypt'  => encrypt($user->email),
                'subject'        => $subject,
                'message'        => $templateText,
                'template_email' => 'emails.recover-password',
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en sendMailRecoverPassword', [
                'user_id' => $user->id ?? null,
                'error'   => $e->getMessage()
            ]);
            return false;
        }
    }
    
    /**
     * Enviar email de notificación
     */
    public function sendMailNotification(array $data): bool
    {
        try {
            return $this->sendMail([
                'name'           => $data['name'] ?: ($data['email'] ?: 'User'),
                'email'          => $data['email'],
                'subject'        => $data['subject'] ?? __t('text.email.template.hello_user'),
                'message'        => $data['message'] ?? '',
                'plan_name'      => $data['plan_name'] ?? null,
                'template_email' => 'emails.notification',
                'bcc'            => $data['bcc'] ?? null,
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error en sendMailNotification', [
                'email' => $data['email'] ?? 'desconocido',
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }
}