<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class StartViteServer extends Command
{
    protected $signature = 'vite:start';
    protected $description = 'Start Vite development server';
    
    public function handle()
    {
        $this->info('Checking if Vite is already running...');
        
        if ($this->isViteRunning()) {
            $this->info('Vite is already running on http://localhost:5174');
            return 0;
        }
        
        $this->info('Starting Vite development server...');
        
        $projectPath = base_path();
        chdir($projectPath);
        
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            pclose(popen('start cmd /k "npm run dev"', 'r'));
        } else {
            exec('nohup npm run dev > storage/logs/vite.log 2>&1 &');
        }
        
        // Wait and check
        $attempts = 0;
        while ($attempts < 10) {
            sleep(2);
            if ($this->isViteRunning()) {
                $this->info('Vite server started successfully!');
                $this->info('URL: http://localhost:5174');
                
                return 0;
            }
            $attempts++;
        }
        
        $this->error('Failed to start Vite server. Check storage/logs/vite.log for details.');
        return 1;
    }
    
    private function isViteRunning(): bool
    {
        $connection = @fsockopen('localhost', 5174, $errno, $errstr, 1);
        if ($connection) {
            fclose($connection);
            return true;
        }
        return false;
    }
}