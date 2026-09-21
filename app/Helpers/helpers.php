<?php


use App\Models\BankHoliday;
use App\Models\Setting;
use App\Models\StaticPage;
use App\Models\Country;
use Carbon\Carbon;


if (!function_exists('convert_amount')) {
    function convert_amount($amount)
    {
        
        if (empty($amount)) {
            return '0.00';
        }
        
        $amount = str_replace('.', '', $amount);
        $amount = str_replace(',', '.', $amount);
        
        return $amount;
    }
}

if (!function_exists('convert_option')) {
    function convert_option($value)
    {
        // Si es null, asignamos 'NO' por defecto
        $value = $value ?? 'NO';
        
        return [
                   1 => 'SI',
                   0 => 'NO',
               ][$value] ?? 'NO'; // <-- fallback por si acaso
    }
}

if (!function_exists('tranform_string')) {
    function tranform_string($value)
    {
        return ucfirst(mb_strtolower($value, 'UTF-8'));
    }
}

if (!function_exists('capitalize_first')) {
    
    function capitalize_first(?string $string): string|null
    {
        
        if (!$string) {
            return null;
        }
        
        return mb_convert_case($string, MB_CASE_TITLE, "UTF-8");
    }
}

if (!function_exists('format_number')) {
    function format_number($value)
    {
        // Limpiar y convertir
        if (is_string($value)) {
            $value = str_replace(',', '.', $value);
            $value = preg_replace('/[^\d\.\-]/', '', $value);
        }
        
        // Validar como float
        $number = filter_var($value, FILTER_VALIDATE_FLOAT);
        
        if ($number === false) {
            return '0'; // Valor inválido
        }
        
        // Verificar decimales
        $decimals = (round($number, 2) == round($number, 0)) ? 0 : 2;
        return number_format($number, $decimals, ',', '.');
    }
}

if (!function_exists('status_register')) {
    function status_register($value)
    {
        return [
                   1 => 'Activo',
                   0 => 'Inactivo',
                   2 => 'Inactivo',
               ][$value];
    }
}

if (!function_exists('date_formt')) {
    function date_formt($value)
    {
        $date = new \DateTime($value);
        return $date->format('d/m/Y');
    }
}

if (!function_exists('sprintf_number')) {
    function sprintf_number($value)
    {
        return sprintf("%010d", $value);
    }
}

if (!function_exists('addMonthsToDate')) {
    function addMonthsToDate($date, $months = 1)
    {
        return \Carbon\Carbon::parse($date)->addMonths($months)->format('Y-m-d H:i:s');
    }
}

if (!function_exists('daysRemaining')) {
    function daysRemaining($expirationDate): int
    {
        $now        = Carbon::now()->startOfDay();
        $expiration = Carbon::parse($expirationDate)->startOfDay();
        
        $days = $now->diffInDays($expiration, false);
        
        return max(0, (int)$days);
    }
}

if (!function_exists('userShortName')) {
    function userShortName()
    {
        $user = Auth::user();
        
        if (!$user?->profile?->first_name) {
            return $user?->email ?? 'Usuario';
        }
        
        $firstName = explode(' ', trim($user->profile->first_name))[0];
        $lastName  = explode(' ', trim($user->profile->last_name))[0];
        
        return $firstName . ' ' . $lastName;
    }
}

if (!function_exists('getImageUrl')) {
    function getImageUrl($path, $img = null, $default = 'img/no-image.jpg')
    {
        if (empty($img)) {
            return asset($default);
        }
        
        $fullPath = $path . '/' . $img;
        
        if (Storage::disk('public')->exists($fullPath)) {
            return Storage::url($fullPath);
        }
        
        return asset($default);
    }
}

if (!function_exists('showStar')) {
    function showStar($punctuation)
    {
        $html = '';
        
        // Asegurar que la puntuación esté en el rango 1-5
        $punctuation = max(1, min(5, (float)($punctuation)));
        
        $wholeScore = floor($punctuation);
        $tieneMedia = ($punctuation - $wholeScore) >= 0.3;
        
        for ($i = 1; $i <= 5; $i++) {
            
            if ($i <= $wholeScore) {
                $html .= '<i class="fas fa-lg fa-star text-warning mr-1"></i>';
            } elseif ($i == ($wholeScore + 1) && $tieneMedia) {
                $html .= '<i class="fas fa-lg fa-star-half-alt text-warning mr-1"></i>';
            } else {
                $html .= '<i class="far fa-lg fa-star text-warning mr-1"></i>';
            }
        }
        
        return $html;
    }
}

if (!function_exists('USDConversion')) {
    function USDConversion($value)
    {
        return \App\Models\Parameter::getUSDConversion($value);
    }
}

if (!function_exists('normalizePhone')) {
    
    function normalizePhone(string $phone, ?int $defaultCountryCode = 58): string
    {
        // Si viene null, usar el código por defecto
        $defaultCountryCode = $defaultCountryCode ?? 58;
        
        // 1. Eliminar todo lo que no sea un número
        $numbers = preg_replace('/[^0-9]/', '', $phone);
        
        if (empty($numbers)) {
            throw new \Exception("El número de teléfono proporcionado no contiene dígitos válidos.");
        }
        
        // 2. Manejo del cero inicial local
        if (str_starts_with($numbers, '0') && strlen($numbers) > 8) {
            $numbers = ltrim($numbers, '0');
        }
        
        // 3. Validación de longitud
        $length = strlen($numbers);
        
        if ($length < 7 || $length > 15) {
            throw new \Exception("La longitud del número de teléfono no es válida.");
        }
        
        // 4. Asegurar código de país
        $defaultCodeStr = (string) $defaultCountryCode;
        
        if ($length <= 11 && !str_starts_with($numbers, $defaultCodeStr)) {
            $numbers = $defaultCodeStr . $numbers;
        }
        
        return $numbers;
    }
}

if (!function_exists('imageToBase64')) {
    function imageToBase64($imagePath)
    {
        if (!$imagePath || !file_exists($imagePath)) {
            return null;
        }
        
        $type   = pathinfo($imagePath, PATHINFO_EXTENSION);
        $data   = file_get_contents($imagePath);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        
        return $base64;
    }
}

if (!function_exists('folder_based_on_file')) {
    function folder_based_on_file($type)
    {
        return match ($type) {
            StaticPage::TYPE_BLOG       => 'blog',
            
            StaticPage::TYPE_PRIVACY,
            StaticPage::TYPE_COOKIES,
            StaticPage::TYPE_TERMS,
            StaticPage::TYPE_WHO_WE_ARE,
            StaticPage::TYPE_OBJETIVE,
            StaticPage::TYPE_PHILOSOPHY => 'photo_page',
            
            default                     => throw new \InvalidArgumentException("Tipo no válido: {$type}"),
        };
    }
}

if (!function_exists('page_style_translation')) {
    function page_style_translation($type)
    {
        return match ($type) {
            StaticPage::TYPE_BLOG       => 'blog',
            
            StaticPage::TYPE_PRIVACY    => 'Privacidad',
            StaticPage::TYPE_COOKIES    => 'Cookies',
            StaticPage::TYPE_TERMS      => 'Términos y condiciones',
            StaticPage::TYPE_WHO_WE_ARE => 'Quiénes somos',
            StaticPage::TYPE_OBJETIVE   => 'Objetivo',
            StaticPage::TYPE_PHILOSOPHY => 'Filosofía',
            
            default                     => throw new \InvalidArgumentException("Tipo no válido: {$type}"),
        };
    }
    
    if (!function_exists('staticPageTypes')) {
        function staticPageTypes()
        {
            return [
                ''                          => 'Seleccione Página Estática...',
                StaticPage::TYPE_PRIVACY    => 'Política de Privacidad',
                StaticPage::TYPE_COOKIES    => 'Política de Cookies',
                StaticPage::TYPE_TERMS      => 'Términos y Condiciones',
                StaticPage::TYPE_BLOG       => 'Blog',
                StaticPage::TYPE_WHO_WE_ARE => 'Quiénes Somos',
                StaticPage::TYPE_OBJETIVE   => 'Objetivo',
                StaticPage::TYPE_PHILOSOPHY => 'Filosofía',
            ];
        }
    }
    
    if (!function_exists('__t')) {
        function __t($key, $default = null, $replace = [], $locale = null)
        {
            $translation = __($key, $replace, $locale);
            
            // Si la traducción es igual a la clave (no existe), usar el default
            if ($translation === $key) {
                return $default ?? $key;
            }
            
            return $translation;
        }
    }
    
    
    if (!function_exists('remove_dashes')) {
        function remove_dashes($text)
        {
            return str_replace('-', ' ', $text);
        }
    }
    
    if (!function_exists('language')) {
        function language()
        {
            return [
                ''                   => 'Seleccione Lenguaje...',
                Country::LANGUAGE_EN => Country::LANGUAGE_EN,
                Country::LANGUAGE_ES => Country::LANGUAGE_ES,
            ];
        }
    }
    
    if (!function_exists('session_language')) {
        function session_language()
        {
            return app()->getLocale() ?? Country::LANGUAGE_EN;
        }
    }
    
    if (!function_exists('plan_style_text')) {
        function plan_style_text($typePlan)
        {
            if (!$typePlan) {
                return null;
            }
            
            $language = app()->getLocale() ?? Country::LANGUAGE_EN;
            
            if ($language == Country::LANGUAGE_EN) {
                $text = match ($typePlan) {
                    'DÍA'    => 'DAY',
                    'MES'    => 'MONTH',
                    'SEMANA' => 'WEEK',
                    default  => null,
                };
            } else {
                $text = $typePlan;
            }
            
            return $text;
        }
    }
    
    if (!function_exists('extractPickParts')) {
        function extractPickParts($html)
        {
            // Limpiar HTML
            $clean = strip_tags($html);
            $clean = html_entity_decode($clean, ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $clean = preg_replace('/\s+/', ' ', $clean);
            $clean = trim($clean);
            
            if (empty($clean)) {
                return [];
            }
            
            // Si ya tiene "|", usarlo como separador
            if (strpos($clean, '|') !== false) {
                $parts = array_map('trim', explode('|', $clean));
                $parts = array_filter($parts);
                return array_values($parts);
            }
            
            // Si no tiene "|", insertar separadores antes de palabras clave
            $keywords = ['Plan:', 'PARLEY', 'REAL', 'ARSENAL', 'BAJA', 'CUOTA'];
            $temp     = $clean;
            
            foreach ($keywords as $keyword) {
                // Insertar "|" antes de cada keyword (excepto si está al inicio)
                $temp = preg_replace('/(?<!^)(?=' . preg_quote($keyword, '/') . ')/', '|', $temp);
            }
            
            // Dividir por "|"
            $parts = array_map('trim', explode('|', $temp));
            $parts = array_filter($parts);
            $parts = array_values($parts);
            
            // Si solo hay 1 parte, intentar dividir por espacio si es largo
            if (count($parts) == 1 && strlen($parts[0]) > 30) {
                // Buscar patrones comunes
                $text     = $parts[0];
                $newParts = [];
                
                // Intentar extraer usando patrones
                if (preg_match('/^(Plan:\s*[^\s]+)/', $text, $match)) {
                    $newParts[] = $match[1];
                    $text       = trim(str_replace($match[1], '', $text));
                }
                
                // Buscar apuestas (REAL MADRID OVER 2.5 GOLES, ARSENAL OVER, etc.)
                if (preg_match('/([A-Z\s]+OVER\s+[\d.]+\s+GOLES)/', $text, $match)) {
                    $newParts[] = $match[1];
                    $text       = trim(str_replace($match[1], '', $text));
                } elseif (preg_match('/([A-Z\s]+UNDER\s+[\d.]+\s+GOLES)/', $text, $match)) {
                    $newParts[] = $match[1];
                    $text       = trim(str_replace($match[1], '', $text));
                }
                
                // Buscar CUOTA
                if (preg_match('/(CUOTA\s*-?\d+\.?\d*)/', $text, $match)) {
                    $newParts[] = $match[1];
                    $text       = trim(str_replace($match[1], '', $text));
                }
                
                // Si hay texto sobrante y es significativo
                if (!empty($text)) {
                    $newParts[] = $text;
                }
                
                if (count($newParts) > 1) {
                    $parts = $newParts;
                }
            }
            
            return $parts;
        }
    }
    
    if (!function_exists('status_payment')) {
        function status_payment($value)
        {
            return [
                       1 => 'succeeded',
                       0 => 'failed',
                   ][$value];
        }
    }
}