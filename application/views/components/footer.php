        <hr>
        <?$this->load->view('components/footer_menu');?>
        <div class="modal" id="contact_modal" tabindex="-1" role="dialog" aria-labelledby="contact_modal" aria-hidden="true"></div>

        <footer>
            <?$this->carabiner->display('bootstrap', 'js');?>
            <?$this->carabiner->display('page_assets', 'js');?>
            <?$this->carabiner->display('footer_js', 'js');?>
        </footer>
    </body>
</html>