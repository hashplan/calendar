        <hr>
        <?$this->load->view('components/footer_menu');?>

        <footer>
            <?$this->carabiner->display('bootstrap', 'js');?>
            <?$this->carabiner->display('page_assets', 'js');?>
            <?$this->carabiner->display('footer_js', 'js');?>
        </footer>
    </body>
</html>