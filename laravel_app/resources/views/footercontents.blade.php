@extends('layout.app')

@section('customCss')
    <link href="{{ asset('css/footercontents.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
    <div class="container text-center">
        <div class="row">
            <div class="col-md-12">
                <section class="contents me-xl-5 ms-xl-5 mt-xl-5">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 text-center mb-4">
                                <h2>Kontakt</h2>
                                <p>
                                    V prípade potreby kontaktujte tieto osoby:
                                    <br><br>
                                    <strong>Petra Miková</strong>
                                    <br>
                                    <a href="mailto:xmikova@stuba.sk">xmikova@stuba.sk</a>
                                    <br><br>
                                    <strong>Laura Popaďáková</strong>
                                    <br>
                                    <a href="mailto:xpopadakova@stuba.sk">xpopadakova@stuba.sk</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="contents me-xl-5 ms-xl-5">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 text-center mb-4">
                                <h2>Obchodné podmienky</h2>
                                <br>
                                <h4>Úvodné ustanovenia</h4>
                                <p>
                                    Tieto obchodné podmienky určujú práva a povinnosti predávajúceho a kupujúceho.<br>
                                    Predávajúci: GeekGlamour s.r.o.<br>
                                    Kupujúci: Osoba, ktorá uzatvára kúpnu zmluvu s predávajúcim.
                                </p>
                                <br>
                                <h4>Objednávka tovaru</h4>
                                <p>
                                    Kupujúci si môže objednať tovar prostredníctvom internetového obchodu, telefonicky alebo e-mailom.<br>
                                    Objednávka sa považuje za platnú až po potvrdení predávajúcim.
                                </p>
                                <br>
                                <h4>Doprava</h4>
                                <p>
                                    Tovar bude dodaný na adresu uvedenú kupujúcim.<br>
                                    Dopravné náklady sú uvedené pri objednávke a sú zahrnuté v konečnej cene tovaru.
                                </p>
                                <br>
                                <h4>Platba</h4>
                                <p>
                                    Kupujúci môže platiť hotovosťou pri prevzatí tovaru, bankovým prevodom alebo platobnou kartou.<br>
                                    Platba je splatná ihneď po uzatvorení objednávky.
                                </p>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="contents me-xl-5 ms-xl-5">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 text-center mb-4">
                                <h2>Reklamácie</h2>
                                <p>
                                    V prípade akéhokoľvek problému s tovarom, má kupujúci právo uplatniť reklamáciu.<br>
                                    Reklamácia musí byť uplatnená do 30 od prevzatia tovaru.<br>
                                    Kupujúci je povinný uviesť dôvod reklamácie a žiadosť o výmenu tovaru alebo vrátenie peňazí.
                                </p>

                                <p>
                                    Predávajúci je povinný vybaviť reklamáciu v súlade so zákonnými normami a podmienkami uvedenými v obchodných podmienkach.<br>
                                    V prípade oprávneného uplatnenia reklamácie je predávajúci povinný zabezpečiť výmenu tovaru, opravu alebo vrátenie peňazí kupujúcemu.
                                </p>

                                <p>
                                    Reklamácia nebude akceptovaná v prípade, že vada vznikla v dôsledku nesprávneho použitia, poškodenia alebo opotrebenia tovaru zo strany kupujúceho.
                                </p>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="contents me-xl-5 ms-xl-5">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 text-center mb-4">
                                <h2>Často kladené otázky (FAQ)</h2>
                                <br>
                                <h5>Ako môžem uskutočniť nákup?</h5>
                                <p>
                                    Nákup môžete uskutočniť jednoducho prostredníctvom našej webovej stránky. Stačí pridať produkty do košíka a postupovať podľa pokynov na obrazovke.
                                </p>

                                <h5>Kedy budem mať objednaný tovar?</h5>
                                <p>
                                    Dodacia lehota sa líši v závislosti od dostupnosti produktu a miesta doručenia. Zvyčajne sa snažíme doručiť objednávky v čo najkratšom čase.
                                </p>

                                <h5>Ako môžem kontaktovať zákaznícku podporu?</h5>
                                <p>
                                    Naša zákaznícka podpora je k dispozícii 24/7 prostredníctvom e-mailu a telefónu. V prípade akýchkoľvek otázok alebo problémov nás neváhajte kontaktovať.
                                </p>

                                <h5>Ako môžem sledovať stav mojej objednávky?</h5>
                                <p>
                                    Po odoslaní objednávky obdržíte e-mail s potvrdením objednávky a sledovacím číslom. Sledovať stav objednávky môžete aj prostredníctvom nášho webového rozhrania.
                                </p>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection
