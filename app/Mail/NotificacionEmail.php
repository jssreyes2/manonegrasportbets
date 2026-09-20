<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;

class NotificacionEmail extends Mailable
{
    use Queueable, SerializesModels;
    
    public array $data;
    private ?string $attachmentData = null;
    private ?string $attachmentName = null;
    private ?string $attachmentMime = null;
    
    /**
     * Create a new message instance.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
        
        // Extraer adjuntos si vienen en los datos
        if (!empty($data['attachment_base64']) && !empty($data['attachment_name'])) {
            $this->attachmentData = $data['attachment_base64'];
            $this->attachmentName = $data['attachment_name'];
            $this->attachmentMime = $data['attachment_mime'] ?? 'application/octet-stream';
        }
    }
    
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $envelope = new Envelope(
            from: new Address(
                config('mail.from.address'),
                config('app.name')
            ),
            subject: $this->data['subject'] ?? 'Notificación',
        );
        
        if (!empty($this->data['bcc'])) {
            $envelope->bcc($this->data['bcc']);
        }
        
        return $envelope;
    }
    
    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        // Determinar qué vista usar
        $view = $this->data['template_email'] ?? 'emails.notification';
        
        return new Content(
            view: $view,
            with: [
                'data' => $this->data,
                'planName' => $this->data['plan_name'] ?? 'N/A',
                'subject' => $this->data['subject'] ?? 'Notificación',
            ],
        );
    }
    
    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        $attachments = [];
        
        // Agregar adjunto si existe
        if ($this->attachmentData && $this->attachmentName) {
            $base64String = $this->attachmentData;
            
            if (strpos($base64String, 'base64,') !== false) {
                $parts = explode('base64,', $base64String);
                $base64String = $parts[1] ?? $base64String;
            }
            
            $binaryData = base64_decode($base64String);
            
            if ($binaryData !== false) {
                // Se usa Attachment::fromData para la sintaxis moderna de Mailables en Laravel
                $attachments[] = Attachment::fromData(fn () => $binaryData, $this->attachmentName)
                    ->withMime($this->attachmentMime);
            }
        }
        
        return $attachments;
    }
}