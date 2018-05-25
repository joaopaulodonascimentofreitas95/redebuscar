<style>
    .phone{color:#F50000; font-weight:bold;}
</style>
<section class="contact" id="contact" style="background-color:#25375C;">
    <div class="container">
        <div class="row">
            <header class="section_header col-lg-12 text-center">
                <h1 class="section-heading text-uppercase">Fale com à <?=SITE_NAME;?></h1>
                <p class="section-subheading text-muted">Dúvidas, Críticas ou Sugestões? Estamos aguardando seu contato!</p>
                <h3 class="phone">85.3046.1100 / 85.9.9199.5058</h3>
            </header>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <form id="contactForm" name="sentMessage" novalidate="">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input class="form-control" id="name" type="text" placeholder="Seu Nome *" required="">
                                <p class="help-block text-danger"></p>
                            </div>
                            <div class="form-group">
                                <input class="form-control" id="email" type="email" placeholder="Seu Email *" required="">
                            </div>
                            <div class="form-group">
                                <input class="form-control" id="phone" type="tel" placeholder="Seu Telefone *" required="">
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" id="message" placeholder="Sua Mensagem *" required=""></textarea>
                            </div>
                             <div class="col-lg-12 text-center">
                                <div id="success"></div>
                                <button id="sendMessageButton" class="btn btn-primary btn-lg text-uppercase" type="submit">Enviar Mensagem</button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <img style="max-height:600px;" src="<?=base_url('assets/images/banner-site-tele-entrega.png')?>" alt="BusCar Auto Peças" title="BusCar Auto Peças"/>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>