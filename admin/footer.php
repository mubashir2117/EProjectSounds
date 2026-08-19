
            <div class="footer">
                <div class="copyright">
                    <p>Copyright &copy; 2024 &mdash; Designed &amp; Developed by <a href="index.php" target="_blank">Sound Music</a></p>
                </div>
            </div>

        </div><!-- /layout-main -->
    </div><!-- /layout-body -->

</div><!-- /main-wrapper -->

<script>
(function () {
    var wrapper = document.getElementById('main-wrapper');
    var toggle = document.getElementById('sidebarToggle');
    if (wrapper && toggle) {
        toggle.addEventListener('click', function () {
            wrapper.classList.toggle('sidebar-collapsed');
        });
    }
})();
</script>

</body>
</html>
