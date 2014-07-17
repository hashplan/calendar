        <hr>
        <div class = "container">
            <ul class=" nav navbar-nav">
                <li><?php echo anchor('page/about','About');?></li>
                <li><?php echo anchor('page/howitworks','How it Works');?></li>
                <li><?php echo anchor('page/faq','FAQ');?></li>
                <li><?php echo anchor('email/contact','Contact', 'data-toggle="modal" data-target="#contact_form"');?></li>
            </ul>
            <ul class = "nav navbar-nav navbar-right">
                <li class = "push-right text-muted">&copy 2014. All rights reserved</li>
            </ul>
        </div>
    </body>
</html>