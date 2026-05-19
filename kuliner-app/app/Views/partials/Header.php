<header id="header" class="header fixed-top d-flex align-items-center bg-light p-3">
    <button type="button" class="btn btn-link me-2" id="sidebar-toggle" style="text-decoration: none;">
        <span style="font-size: 24px; color: #012970; cursor: pointer;">☰</span>
    </button>
    
    <h4 class="mb-0">Culinary</h4>
</header>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const toggleBtn = document.getElementById('sidebar-toggle');
        
        if (toggleBtn) {
            toggleBtn.addEventListener('click', function() {
                // Kita coba toggle class 'toggle-sidebar' pada body 
                // (Ini standar template Bootstrap/NiceAdmin)
                document.body.classList.toggle('toggle-sidebar');
                
                // Jika sidebar kamu punya ID sendiri, misalnya 'sidebar'
                const sidebar = document.getElementById('sidebar');
                if (sidebar) {
                    sidebar.classList.toggle('active');
                }
                
                console.log("Tombol toggle berhasil diklik!");
            });
        }
    });
</script>