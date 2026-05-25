<?php

namespace App\View\Components\Atoms;

use Illuminate\View\Component;
use Illuminate\Support\Facades\File;

class ApplicationLogo extends Component
{
    public string $svgContent;
    public string $colorClass;

    /**
     * Create a new component instance.
     *
     * @param string $color The desired color version ('white', 'primary', or a specific Tailwind color class like 'text-blue-500').
     */
    public function __construct(string $color = 'primary') // Default to 'primary'
    {
        $svgPath = public_path('image/logo.svg');
        if (File::exists($svgPath)) {
            $this->svgContent = File::get($svgPath);
        } else {
            // Fallback SVG or error handling if the file is not found
            // Using a simple placeholder SVG from Heroicons for demonstration
            $this->svgContent = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6"><path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12ZM12 8.25a.75.75 0 0 1 .75.75v3.75a.75.75 0 0 1-1.5 0V9a.75.75 0 0 1 .75-.75Zm0 8.25a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" clip-rule="evenodd" /></svg>';
            \Log::warning("Application logo SVG file not found at: " . $svgPath);
        }

        // Determine the Tailwind color class based on the input color
        switch ($color) {
            case 'white':
                $this->colorClass = 'text-white';
                break;
            case 'primary':
                // Menggunakan shade 400 dari palet primary di tailwind.config.js Anda
                $this->colorClass = 'text-primary-400';
                break;
            default:
                // Memungkinkan untuk meneruskan kelas warna Tailwind secara langsung, misal 'text-red-500'
                $this->colorClass = $color;
                break;
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.atoms.application-logo', [
            'svgContent' => $this->svgContent,
            'colorClass' => $this->colorClass,
        ]);
    }
}