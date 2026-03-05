<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if($activo)
        document.addEventListener('keydown', function(e) {
            if (e.key === 'ArrowLeft' && {{ $activoAnterior ? 'true' : 'false' }}) {
                window.location.href = "{{ $activoAnterior ? route('activos.index', ['id' => $activoAnterior->folio]) : '#' }}";
            }
            
            if (e.key === 'ArrowRight' && {{ $activoSiguiente ? 'true' : 'false' }}) {
                window.location.href = "{{ $activoSiguiente ? route('activos.index', ['id' => $activoSiguiente->folio]) : '#' }}";
            }
            
            if (e.key === 'Home' && {{ $primerActivo ? 'true' : 'false' }}) {
                window.location.href = "{{ $primerActivo ? route('activos.index', ['id' => $primerActivo->folio]) : '#' }}";
            }
            
            if (e.key === 'End' && {{ $ultimoActivo ? 'true' : 'false' }}) {
                window.location.href = "{{ $ultimoActivo ? route('activos.index', ['id' => $ultimoActivo->folio]) : '#' }}";
            }
            
            if (e.ctrlKey && e.key === 'f') {
                e.preventDefault();
                document.getElementById('search-input').focus();
                document.getElementById('search-input').select();
            }
        });
        @endif
        
        const sectionHeaders = document.querySelectorAll('.section-header');
        sectionHeaders.forEach(header => {
            header.style.cursor = 'pointer';
            header.addEventListener('click', function() {
                const body = this.nextElementSibling;
                if (body.style.display === 'none') {
                    body.style.display = 'block';
                    this.querySelector('i').style.transform = 'rotate(0deg)';
                } else {
                    body.style.display = 'none';
                    this.querySelector('i').style.transform = 'rotate(-90deg)';
                }
            });
        });
        
        const searchInput = document.getElementById('search-input');
        if (searchInput && searchInput.value) {
            setTimeout(() => {
                searchInput.select();
            }, 100);
        }
        
    });
</script>