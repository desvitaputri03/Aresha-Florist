<!-- Shared scripts for layouts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Auto-hide alerts helper
    setTimeout(function() {
        document.querySelectorAll('.alert').forEach(alert => {
            try { new bootstrap.Alert(alert).close(); } catch(e) {}
        });
    }, 5000);

    // Smooth scroll helper for anchors
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });
</script>
