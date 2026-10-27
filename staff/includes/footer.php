<?php
// staff/includes/footer.php
?>
</div><!-- portal-layout -->

<script>
    async function handleLogout() {
        try { 
            await fetch("../api/logout.php"); 
        } catch(e) {}
        sessionStorage.clear();
        window.location.replace('../login.php');
    }
</script>
</body>
</html>
