@extends('layouts.layout')

@section('styles')
    @vite(['resources/css/home.css'])
@endsection

@section('content')
<nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand" href="#page-top"><img src={{ Vite::asset('resources/images/Forestfyw.png') }} alt="..." /></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="fas fa-bars ms-1"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav text-uppercase ms-auto py-4 py-lg-0">
                <li class="nav-item"><a class="nav-link" href="#services">Como funciona</a></li>
                <li class="nav-item"><a class="nav-link" href="#about">Vantagens</a></li>
                <li class="nav-item"><a class="nav-link" href="#contact">Contato</a></li>
                @if ($user)
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Olá, {{$user['user_name']}}!</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href={{ route('jobs') }}>Painel</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href={{ route('logout') }}>Sair</a></li>
                        </ul>
                    </li>
                @else
                    {{-- <li class="nav-item"><a class="nav-link" href={{ route('register') }}>Cadastre-se</a></li> --}}
                    <li class="nav-item"><a class="nav-link" href={{ route('login') }}>Entrar</a></li>
                @endauth

            </ul>
        </div>
    </div>
</nav>
<!-- Masthead-->
<header class="masthead">
    <div class="container">
        <div class="masthead-subheading">Bem vindo ao Forestfy!</div>
        <div class="masthead-heading text-uppercase">Maximizando o corte de árvores para a retabilidade</div>
        <a class="btn btn-primary btn-xl text-uppercase" href="#services">Saiba Mais</a>
    </div>
</header>
<!-- Services-->
<section class="page-section" id="services">
    <div class="container">
        <div class="text-center">
            <h2 class="section-heading text-uppercase">Como funciona</h2>
            <h3 class="section-subheading text-muted">Nosso algoritmo inteligente de gerenciamento de florestas ajuda você a maximizar a rentabilidade na colheita de árvores.</h3>
        </div>
        <div class="row text-center">
            <div class="col-md-3">
                <span class="fa-stack fa-4x">
                    <i class="fas fa-circle fa-stack-2x text-primary"></i>
                    <i class="fas fa-chart-line fa-stack-1x fa-inverse"></i>
                </span>
                <h4 class="my-3">Planejamento</h4>
                <p class="text-muted">Nós criamos um modelo detalhado e preciso do seu terreno.</p>
            </div>
            <div class="col-md-3">
                <span class="fa-stack fa-4x">
                    <i class="fas fa-circle fa-stack-2x text-primary"></i>
                    <i class="fas fa-person-chalkboard fa-stack-1x fa-inverse"></i>
                </span>
                <h4 class="my-3">Recomendações Personalizadas</h4>
                <p class="text-muted">Nosso algoritmo analisa os dados e recomenda as melhores árvores para corte.</p>
            </div>
            <div class="col-md-3">
                <span class="fa-stack fa-4x">
                    <i class="fas fa-circle fa-stack-2x text-primary"></i>
                    <i class="fas fa-tree fa-stack-1x fa-inverse"></i>
                </span>
                <h4 class="my-3">Simulação de Corte</h4>
                <p class="text-muted">Nós fornecemos uma simulação do corte ideal para ajudá-lo a tomar a melhor decisão.</p>
            </div>
            <div class="col-md-3">
                <span class="fa-stack fa-4x">
                    <i class="fas fa-circle fa-stack-2x text-primary"></i>
                    <i class="fas fa-file fa-stack-1x fa-inverse"></i>
                </span>
                <h4 class="my-3">Relatório Detalhado</h4>
                <p class="text-muted">Você recebe um relatório detalhado sobre o corte de cada árvore.</p>
            </div>
        </div>
    </div>
</section>
<!-- About-->
<section class="page-section" id="about">
    <div class="container">
        <div class="text-center">
            <h2 class="section-heading text-uppercase">NOSSAS VANTAGES</h2>
            <h3 class="section-subheading text-muted">Por que escolher o nosso site de planejamento florestal? Porque nós oferecemos as seguintes vantagens:</h3>
        </div>
        <ul class="timeline">
            <li>
                <div class="timeline-image"><img class="rounded-circle img-fluid" src={{ Vite::asset('resources/images/sustentabilidade.png') }} alt="..." /></div>
                <div class="timeline-panel">
                    <div class="timeline-heading">
                        <h4>Sustentabilidade</h4>
                        <h4></h4>
                    </div>
                    <div class="timeline-body"><p class="text-muted">Nós usamos um algoritmo inteligente que calcula o melhor corte de árvore, levando em conta o impacto ambiental, a regeneração natural e a demanda do mercado. Assim, você garante a sustentabilidade do seu negócio florestal e contribui para a preservação da natureza.</p></div>
                </div>
            </li>
            <li class="timeline-inverted">
                <div class="timeline-image"><img class="rounded-circle img-fluid" src={{ Vite::asset('resources/images/eficiencia.png') }} alt="..." /></div>
                <div class="timeline-panel">
                    <div class="timeline-heading">
                        <h4>Eficiência</h4>
                    </div>
                    <div class="timeline-body"><p class="text-muted">Nós otimizamos o seu tempo e o seu dinheiro, pois o nosso algoritmo indica o momento ideal, 
                                    a quantidade e a qualidade do corte de árvore, evitando desperdícios e maximizando os lucros. Além disso, 
                                    você pode acompanhar o seu planejamento florestal em tempo real, através de um painel interativo e fácil de usar.</p></div>
                </div>
            </li>
            <li>
                <div class="timeline-image"><img class="rounded-circle img-fluid" src={{ Vite::asset('resources/images/forest.png') }} alt="..." /></div>
                <div class="timeline-panel">
                    <div class="timeline-heading">
                        <h4>Planejamento Inteligente</h4>
                    </div>
                    <div class="timeline-body"><p class="text-muted">Nós oferecemos um serviço personalizado e completo de planejamento florestal, que abrange desde a análise do solo, 
                                                         a escolha das espécies, o plantio, a manutenção, a colheita e o transporte. 
                                                        Você conta com o suporte de uma equipe de profissionais qualificados, que estão sempre à disposição para tirar as suas dúvidas e orientar as suas decisões.</p></div>
                </div>
            </li>
            <li class="timeline-inverted">
                <div class="timeline-image"><img class="rounded-circle img-fluid" src={{ Vite::asset('resources/images/inovacao.png') }} alt="..." /></div>
                <div class="timeline-panel">
                    <div class="timeline-heading">
                        <h4>Inovação</h4>
                    </div>
                    <div class="timeline-body"><p class="text-muted">Nós estamos sempre buscando novas soluções e melhorias para o seu negócio florestal, acompanhando as tendências e as 
                                                        necessidades do mercado.</p></div>
                </div>
            </li>
        </ul>
    </div>
</section>
<!-- Contact-->
<section class="page-section" id="contact">
    <div class="container">
        <div class="text-center">
            <h2 class="section-heading text-uppercase">Contato</h2>
            <h3 class="section-subheading text-muted">Faça sua avaliação gratuita para obter uma cotação personalizada.</h3>
        </div>
        <!-- * * * * * * * * * * * * * * *-->
        <!-- * * SB Forms Contact Form * *-->
        <!-- * * * * * * * * * * * * * * *-->
        <!-- This form is pre-integrated with SB Forms.-->
        <!-- To make this form functional, sign up at-->
        <!-- https://startbootstrap.com/solution/contact-forms-->
        <!-- to get an API token!-->
        <form id="contactForm" data-sb-form-api-token="API_TOKEN">
            <div class="row align-items-stretch mb-5">
                <div class="col-md-6">
                    <div class="form-group">
                        <!-- Name input-->
                        <input class="form-control" id="name" type="text" placeholder="Seu Nome *" data-sb-validations="required" />
                        <div class="invalid-feedback" data-sb-feedback="name:required">O nome é obrigatório.</div>
                    </div>
                    <div class="form-group">
                        <!-- Email address input-->
                        <input class="form-control" id="email" type="email" placeholder="Seu Email *" data-sb-validations="required,email" />
                        <div class="invalid-feedback" data-sb-feedback="email:required">O email é obrigatório.</div>
                        <div class="invalid-feedback" data-sb-feedback="email:email">O email não é válido.</div>
                    </div>
                    <div class="form-group mb-md-0">
                        <!-- Phone number input-->
                        <input class="form-control" id="phone" type="tel" placeholder="Seu Telefone *" data-sb-validations="required" />
                        <div class="invalid-feedback" data-sb-feedback="phone:required">O número de telefone é obrigatório.</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group form-group-textarea mb-md-0">
                        <!-- Message input-->
                        <textarea class="form-control" id="message" placeholder="Sua Mensagem *" data-sb-validations="required"></textarea>
                        <div class="invalid-feedback" data-sb-feedback="message:required">A mensagem é obrigatória.</div>
                    </div>
                </div>
            </div>
            <!-- Submit success message-->
            <!---->
            <!-- This is what your users will see when the form-->
            <!-- has successfully submitted-->
            <div class="d-none" id="submitSuccessMessage">
                <div class="text-center text-white mb-3">
                    <div class="fw-bolder">Form submission successful!</div>
                    To activate this form, sign up at
                    <br />
                    <a href="https://startbootstrap.com/solution/contact-forms">https://startbootstrap.com/solution/contact-forms</a>
                </div>
            </div>
            <!-- Submit error message-->
            <!---->
            <!-- This is what your users will see when there is-->
            <!-- an error submitting the form-->
            <div class="d-none" id="submitErrorMessage"><div class="text-center text-danger mb-3">Erro ao enviar a mensagem!</div></div>
            <!-- Submit Button-->
            <div class="text-center"><button class="btn btn-primary btn-xl text-uppercase" id="submitButton" type="submit">Enviar Mensagem</button></div>
        </form>
    </div>
</section>
<!-- Footer-->
<footer class="footer py-4">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-4 text-lg-start"></div>
            <div class="col-lg-4 my-3 my-lg-0">
                <a class="btn btn-dark btn-social mx-2" href="#!" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                <a class="btn btn-dark btn-social mx-2" href="#!" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a class="btn btn-dark btn-social mx-2" href="#!" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a class="link-dark text-decoration-none me-3" href="#!">Política de Privacidade</a>
                <a class="link-dark text-decoration-none" href="#!">Termos de Uso</a>
            </div>
        </div>
    </div>
</footer>
@endsection
@section('scripts')
    @vite(['resources/js/home.js'])
@endsection
