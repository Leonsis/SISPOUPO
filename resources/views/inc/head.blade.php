@php
     use App\Models\Style;
    use Illuminate\Support\Facades\Auth;
    
    $style = null;
    if (Auth::check()) {
        $style = Style::where('user_id', Auth::id())->first();
    }
    
    // ✅ Usa variáveis individuais
    $corPrimaria = $style->cor_primaria ?? '#f5b645';
    $corSecundaria = $style->cor_secundario ?? '#6c757d';
    $corFundo = $style->cor_fundo ?? '#1a1a1a';
    $corTexto = $style->cor_texto ?? '#ffffff';
    
    // Função para converter HEX para RGB
    function hexToRgb($hex) {
        $hex = str_replace('#', '', $hex);
        
        if (strlen($hex) == 3) {
            $r = hexdec(str_repeat(substr($hex, 0, 1), 2));
            $g = hexdec(str_repeat(substr($hex, 1, 1), 2));
            $b = hexdec(str_repeat(substr($hex, 2, 1), 2));
        } else {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }
        
        return "$r, $g, $b";
    }
    
    // ✅ Converte para RGB (string, não array)
    $corPrimariaRgb = hexToRgb($corPrimaria);
    $corSecundariaRgb = hexToRgb($corSecundaria);
    $corFundoRgb = hexToRgb($corFundo);
    $corTextoRgb = hexToRgb($corTexto);
@endphp

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SisPoupo</title>
    <!-- Bootstrap 5.3.8 -->
    <link rel="stylesheet" href="{{ asset('bootstrap-5.3.8-dist/css/bootstrap.min.css') }}">
    <script src="{{ asset('bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('jquery-4.0.0.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <!-- Bootstrap Icons (para os ícones) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        :root {
            --var-cor-primaria: {{ $style->cor_primaria ?? '#f5b645' }};
            --var-cor-secundaria: {{ $style->cor_secundario ?? '#1a1a2e' }};
            --var-cor-fundo: {{ $style->cor_fundo ?? '#0d0d1a' }};
            --var-cor-texto: {{ $style->cor_texto ?? '#cccccc' }};
            
            /* RGB - para uso com RGBA() */
            --var-cor-primaria-rgb: {{ $corPrimariaRgb }};            
            --var-cor-secundaria-rgb: {{ $corSecundariaRgb }};
            --var-cor-fundo-rgb: {{ $corFundoRgb }};
            --var-cor-texto-rgb: $corTextoRgb;
        }
    </style>
</head>