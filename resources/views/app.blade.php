<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="es-ES">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <title>TusTurnosOnline.com</title>
  <link rel="home" href="/">
  <!-- Page Meta -->
  <meta name="title" content="TusTurnosOnline.com">
  <meta name="description" content="Obtené tus turnos con agilidad en TusTurnosOnline.com-">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="mobile-web-app-capable" content="yes">
  <link rel="manifest" href="/manifest.json">
  <link rel="shortcut icon" href="/favicon.png" type="image/x-icon">
  <link rel="apple-touch-icon" href="/img/apple-touch-icon.png" type="image/x-icon">

  <!-- Styles -->
  <link rel="stylesheet" href="/css/bulma.css">
  <link rel="stylesheet" href="/css/hero.css">
  <link rel="stylesheet" href="/css/snackbar.css">
  <link rel="stylesheet" href="/css/gibson.css">
</head>
<body>
  <div id="app">
    <div v-show="$root.loading" class="spinner-outer fadeIn"><div class="spinner" data-layer="4"><div class="spinner-container"><div class="spinner-rotator"><div class="spinner-left"><div class="spinner-circle"></div></div><div class="spinner-right"><div class="spinner-circle"></div></div></div></div><div class="spinner-message" v-html="$root.message"></div></div></div>
    
    <div v-show="!$root.loading">
      <nav class="navbar is-fixed-top hidden-loading">
        <div class="container">
          <div class="navbar-brand">
            <a class="navbar-item" @click="homeClick" href="#">
              <img src="/img/logo.png" alt="Tusturnosonline">
            </a>
            <div class="menu-bg"></div>
            <div class="menu-burger">🍔</div>
            <div class="menu-items">
              <a href="/"><img src="/img/logo.png"></a>
              <div class="menu-links">
                <a v-for="navitem in $root.navitems" :href="navitem.slug" v-html="navitem.title"></a>
              </div>
              <a href="#" v-if="$root.token().token" @click="$root.endSessionWithConfirm()" class="button">Cerrar sesión</a>
              <a href="/sign-in" v-if="!$root.token().token" class="button">Iniciar sesión</a>
            </div>    
          </div>
        </div>
      </nav>

      <nav class="navbar custom-navbar is-fixed-top">
        <div class="container">
          <div class="section-tag-container">
            <div class="section-tag columns is-mobile reset-margin">
              <div class="column has-text-right">
                <img class="icon">
              </div>
              <div class="column fadeIn">
                <h3 class="title"></h3>
              </div>
            </div>
          </div>
          <div class="navbar-brand">
            <a class="navbar-item" @click="homeClick" href="#">
              <img src="/img/logo.png" alt="Tusturnosonline">
            </a>
          </div>
          <div class="navbar-menu">
            <div class="navbar-end">
              <div class="navbar-tabs is-right">
                <ul>
                  <li>
                    <a href="/account" class="weberplast">
                      <img src="/img/weberplast.png" width="140">
                    </a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </nav>
      
      <keep-alive exclude="quote,color,account,formularcolor,formularcolordatos,formularcolorcotizacion,basededatos,cotizacionesrealizadas,cargarformulaspropias,formulapropia,historico,contact">
        <router-view :key="$route.fullPath"></router-view>
      </keep-alive>

      <div class="scrollmap">
        <a href="#" @click="scrollUp" class="navbar-item up"><span>👆</span></a>
        <a href="#" @click="scrollDown" class="navbar-item active down"><span>👇</span></a>
      </div>

      <div class="ui-snackbar ui-snackbar--is-inactive">
        <p class="ui-snackbar__message" v-html="$root.message"></p>
      </div>

      <div class="tosprompt">
        <div class="notification">
          <!--p class="has-text-weight-semibold">Ads help us run this site</p-->
          <p>Utilizamos cookies de análisis para mejorar su experiencia y mejorar esta herramienta. No compartimos sus datos personales con otros. <a href="https://puntoweberplast.com/politica-de-privacidad">Leer mas</a></p>
          <div class="has-text-centered">
            <div class="button" onclick="tosAgree(this)">Acepto</div>
          </div>
        </div>
      </div>
      <footer class="footer"></footer>
    </div>    
  </div>
  
  <script type="text/x-template" id="section">
    <div class="section-container">
      <div v-if="data.slug === '/'" v-html="data.content"></div>
      <div v-if="data.slug != '/'" class="hero-picture fadein" v-if="data.pic1_url" :style="'background-image:url(\'' + data.pic1_url + '\')'">
        <div class="hero-text">
          <h1 class="is-uppercase" v-html="data.title"></h1>
          <p class="subtitle" v-html="data.intro"></p>
        </div>
      </div>
      <div v-if="data.slug != '/'" class="hero-body">
        <div class="container is-padded-top">
          <div class="content">
            <h3 class="is-uppercase" v-html="data.title"></h3>
            <div class="is-uppercase" v-html="data.intro"></div>
            <div v-html="data.content_html"></div>
          </div>
        </div>  
      </div>
    </div>
  </script>

  <script type="text/x-template" id="account">
    <div class="has-action-space">
      <div class="container is-padded-top">
        <div class="content hero-system fadeIn">
          <div class="columns is-menu is-vcentered is-dial has-text-centered">
            <div class="column">
              <a href="/clientes">
                <div class="item">
                  <span class="is-size-2">👥</span>
                </div>
                <h4>CRM<br>Clientes</h4>
              </a>
            </div>
            <div class="column">
              <a href="/atributos">
                <div class="item">
                  <span class="is-size-2">🔖</span>
                </div>
                <h4>CRM<br>Atributos</h4>
              </a>
            </div>
            <div class="column">
              <a href="/carga">
                <div class="item">
                  <span class="is-size-2">📙</span>
                </div>
                <h4>Carga<br>de datos</h4>
              </a>
            </div>
            <div class="column">
              <a href="/edit">
                <div class="item">
                  <span class="is-size-2">👤</span>
                </div>
                <h4>Mi<br>cuenta</h4>
              </a>
            </div>
          </div>
        </div>
      </div>
      <div class="content">
        <div class="columns is-vcentered wp-action-space fadeIn">
          <div class="column">
            <div class="control has-text-centered">
              <router-link class="button" to="/contact#formulaciones">Contacto formulaciones</router-link>
              <router-link class="button" to="/contact#marketing">Contacto marketing</router-link>
            </div>
          </div>    
        </div>
      </div>
    </div>      
  </script>

  <script type="text/x-template" id="formulaspropias">
    <div class="has-action-space">
      <div class="container is-padded-top">
        <div class="content hero-system fadeIn">
          <div class="columns is-menu is-vcentered is-dial has-text-centered">
            <div class="column is-hidden-mobile"></div>
            <div class="column">
              <a href="/formulas-propias/historico">
                <div class="item">
                  <img src="/img/formulas-o.png">
                </div>
                <h4>Histórico</h4>
              </a>
            </div>
            <div class="column">
              <a href="/formulas-propias/cargar-formulas-propias">
                <div class="item">
                  <img src="/img/formulas-o.png">
                </div>
                <h4>Cargar<br>Fórmulas<br>propias</h4>
              </a>
            </div>
            <div class="column is-hidden-mobile"></div>
          </div>
        </div>
      </div>
      <div class="content">
        <div class="columns is-vcentered wp-action-space fadeIn">
          <div class="column">
            <div class="control has-text-centered">
              <router-link class="button" to="/account">Volver al menú principal</router-link>
            </div>
          </div>    
        </div>
      </div>
    </div>      
  </script>

  <script type="text/x-template" id="quote">
    <div class="has-action-space">
      <div class="container is-padded-top">
        <div class="content hero-system">
          <div class="columns has-text-centered fadeIn">
            <div class="column">
              <h4 class="is-uppercase">Cotización realizada</h4>
              <form class="form is-dark is-condensed has-text-left">
                <div class="columns is-vcentered">
                  <div class="column is-4">
                    <label class="label">Cliente</label>
                  </div>
                  <div class="column">
                    <input v-model="quote.customer" class="input" type="text" placeholder="Ingresá tu nombre" readonly>
                  </div>
                </div>

                <div class="columns is-vcentered">
                  <div class="column is-4">
                    <label class="label">Textura</label>
                  </div>
                  <div class="column">
                    <input v-model="quote.textures" class="input" type="text" placeholder="Textura" readonly>
                  </div>
                </div>
                <div class="columns is-vcentered">
                  <div class="column is-4">
                    <label class="label">Color</label>
                  </div>
                  <div class="column">
                    <input v-model="quote.colors" class="input" type="text" placeholder="Color" readonly>
                  </div>
                </div>
                <div class="columns is-vcentered">
                  <div class="column is-4">
                    <label class="label">Nro. de Baldes</label>
                  </div>
                  <div class="column is-2">
                    <input v-model="quote.qty" class="input" type="text" placeholder="8" readonly>
                  </div>
                  <div class="column has-text-right">
                    <label class="label">Tamaño</label>
                  </div>
                  <div class="column">
                    <input v-model="quote.packs" class="input" type="text" placeholder="8" readonly>
                  </div>
                </div>
                <div class="columns is-vcentered">
                  <div class="column is-4">
                    <label class="label">Costo unitario</label>
                  </div>
                  <div class="column">
                    <input v-model="quote.unit_price" class="input" type="text" placeholder="$" readonly>
                  </div>
                </div>
                <div class="columns is-vcentered">
                  <div class="column is-4">
                    <label class="label">Costo total</label>
                  </div>
                  <div class="column">
                    <input v-model="quote.subtotal" class="input" type="text" placeholder="$" readonly>
                  </div>
                </div>
                <div v-if="quote.discount" class="columns is-vcentered">
                  <div class="column is-4">
                    <label class="label">Bonificación (%)</label>
                  </div>
                  <div class="column">
                    <input v-model="quote.discount" class="input" type="text" placeholder="%" readonly="">
                  </div>
                </div>
                <div v-if="quote.subtotal_discount" class="columns is-vcentered">
                  <div class="column is-4">
                    <label class="label">Costo total con Bonificación</label>
                  </div>
                  <div class="column">
                    <input v-model="quote.subtotal_discount" class="input" type="text" placeholder="$" readonly="">
                  </div>
                </div>
                <div class="columns is-vcentered">
                  <div class="column is-4">
                    <label class="label">Costo total con IVA</label>
                  </div>
                  <div class="column">
                    <input v-model="quote.total" class="input" type="text" placeholder="$" readonly>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="content">
        <div class="columns is-vcentered wp-action-space fadeIn">
          <div class="column">
            <div class="control has-text-centered">
              <button class="button" href="#" @click="download" :uuid="quote.uuid">Imprimir cotización</button> &nbsp;
              <router-link class="button" :to="'/color/' + quote.uuid">Formular</router-link>
            </div>
          </div>    
        </div>
      </div>
    </div>
  </script>

  <script type="text/x-template" id="color">
    <div class="has-action-space">
      <div class="container is-padded-top">
        <div class="content hero-system">
          <div class="columns has-text-centered fadeIn">
            <div class="column">
              <h4 class="is-uppercase">Formular</h4>
              <form class="form is-dark is-condensed has-text-left">
                <input type="hidden" v-model="performance">
                <div class="columns is-vcentered">
                  <div class="column is-4">
                    <label class="label">Cliente</label>
                  </div>
                  <div class="column">
                    <input v-model="data.quote.customer" class="input" type="text" placeholder="Ingresá tu nombre" readonly>
                  </div>
                </div>

                <div class="columns is-vcentered">
                  <div class="column is-4">
                    <label class="label">Nro. de baldes</label>
                  </div>
                  <div class="column">
                    <input v-model="data.quote.qty" class="input" type="text" placeholder="Nro. de baldes" readonly>
                  </div>
                </div>
                <div class="columns is-vcentered">
                  <div class="column is-4">
                    <label class="label">Envase</label>
                  </div>
                  <div class="column">
                    <input v-model="data.quote.packs" class="input" type="text" placeholder="Envase" readonly>
                  </div>
                </div>
                <div class="columns is-vcentered">
                  <div class="column is-4">
                    <label class="label">Color</label>
                  </div>
                  <div class="column">
                    <input v-model="data.quote.colors" class="input" type="text" placeholder="Color" readonly="">
                  </div>
                </div>
                <div class="columns is-vcentered">
                  <div class="column is-4">
                    <label class="label">Equipo</label>
                  </div>
                  <div class="column">
                    <select v-model="mac_id" @change="updateMac()" class="select" id="mac">
                      <option v-for="mac in data.machines" :value="mac.id" v-html="mac.title"></option>
                    </select>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <div v-if="mac_id" class="has-action-space">
            <div class="is-weberbox">
              <div class="columns is-vcentered is-dark padless-bottom">
                <div class="column">
                  <img src="/img/logo.png" width="180">
                </div>
                <div class="column is-3 has-text-right">
                  <div class="columns is-vcentered">
                    <div class="column has-text-right is-hidden-mobile">
                      <span class="is-uppercase has-text-centered has-text-weight-semibold">Textura</span>
                    </div>
                    <div>
                      <span class="input has-text-centered has-text-style-normal has-text-weight-semibold" :style="'background-color:#' + data.quote.texture_hexcode" v-html="data.quote.textures"></span>
                    </div>
                  </div>
                </div>
                <div class="column is-2 has-text-left">
                  <div class="columns is-vcentered">
                    <div class="column has-text-right is-hidden-mobile">
                      <span class="is-uppercase has-text-weight-semibold">Base</span>
                    </div>
                    <div>
                      <span class="input has-text-centered has-text-style-normal has-text-weight-semibold" v-html="data.quote.bases"></span>
                    </div>
                  </div>
                </div>
                <div class="column is-1"></div>
              </div>
              <div v-show="data.machine.units" class="is-dark is-cotizacionesrealizadas fadeIn">
                <div class="columns is-hidden-mobile">
                  <div class="column">
                    <div class="input has-background-black has-text-weight-semibold has-text-centered has-text-style-normal is-uppercase">Colorantes</div>
                  </div>
                  <div class="column" v-for="(unit,index3) in data.machine.units">
                    <div class="input has-background-black has-text-weight-semibold has-text-centered has-text-style-normal is-uppercase" v-html="$root.unitLabel(unit)"></div>
                  </div>
                </div>
                <div class="columns" v-for="(formula,index) in data.formulas">
                  <div class="column">
                    <div class="input has-text-style-normal has-text-centered" :style="'background-color:#' + formula.hexcode">
                      <span class="has-text-white has-text-weight-semibold" :class="{ 'has-text-black' : formula.colorant == 'AXX' || formula.colorant == 'KX' }" v-html="formula.colorant"></span>
                    </div>
                  </div>
                  <div class="column" v-for="(amount,index2) in formula.amounts">
                    <div class="input has-text-centered has-text-style-normal" v-html="amount"></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="column has-text-centered">
              <a class="button" @click="download" :uuid="data.quote.uuid">Guardar e imprimir fórmula</a>
            </div>
          </div>
        </div>  
      </div>
      <div class="content">
        <div class="columns is-vcentered wp-action-space fadeIn">
          <div class="column is-hidden-mobile"></div>
          <div class="column has-text-centered is-dark">
            <div class="columns">
              <div class="column padless-bottom">
                <div class="input is-uppercase has-text-style-normal is-size-6 has-text-weight-semibold has-text-centered has-text-white">Observaciones</div>
              </div>
            </div>
            <div class="columns">
              <div class="column">
                <textarea class="textarea input comments" v-model="data.quote.comments"></textarea>
              </div>
            </div>
          </div>    
          <div class="column is-hidden-mobile"></div>
        </div>
      </div>
    </div>              
  </script>

  <script type="text/x-template" id="historico">
    <div class="has-action-space">
      <div class="container is-padded-top">
        <div class="content hero-system is-dark fadeIn">
          <div class="columns is-vcentered">
            <div class="column has-text-centered">
              <h3>Histórico</h3>
              <label class="is-size-5"><span class="has-text-danger" v-html="$root.token().first_name"></span> <span class="has-text-danger" v-html="$root.token().last_name"></span>, <span v-if="data.colors.length">éstas son las fórmulas que creaste</span><span v-if="!data.colors.length">todavía no creaste fórmulas</span></label>
            </div>
          </div>
          <div class="has-text-centered is-cotizacionesrealizadas">
            <div v-if="data.colors.length">
              <div class="columns is-hidden-mobile">
                <div class="column has-text-centered">Producto</div>
                <div class="column has-text-centered">Base</div>
                <div class="column has-text-centered">Color</div>
                <div class="column has-text-centered">Fecha</div>
                <div class="column"></div>
                <div class="column"></div>
              </div>
              <div class="columns" v-for="color in data.colors">
                <div class="column">
                  <div class="input has-text-weight-semibold has-text-style-normal is-size-6" :style="'background-color:#' + color.texture_hexcode" v-html="color.texture"></div>
                </div>
                <div class="column">
                  <div class="input is-size-6" v-html="color.base"></div>
                </div>
                <div class="column">
                  <div class="input is-size-6" v-html="color.title"></div>
                </div>
                <div class="column">
                  <div class="input is-size-6" v-html="color.created"></div>
                </div>
                <div class="column">
                  <router-link :to="'/formula/' + color.id" class="input has-text-centered has-text-style-normal">Ver mas</router-link>
                </div>
                <div class="column">
                  <a class="input has-text-centered has-background-danger has-text-style-normal" @click="remove" :id="color.id">Eliminar</a>
                </div>
                <hr class="is-hidden-tablet"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="content">
        <div class="columns is-vcentered wp-action-space fadeIn">
          <div class="column">
            <div class="control has-text-centered">
              <router-link class="button" to="/formulas-propias">Volver a Fórmulas propias</router-link>
            </div>
          </div>    
        </div>
      </div>
    </div>    
  </script>

  <script type="text/x-template" id="cargarformulaspropias">
    <div class="has-action-space">
      <div class="container is-padded-top">
        <div class="content hero-system fadeIn">
          <div class="columns has-text-centered">
            <div class="column">
              <div class="">
                <h4>Elegí equipo e ingresá los datos de tu fórmula</h4>
              </div>
              <!--pre v-html="data.colorants"></pre-->
              <form class="form is-dark is-condensed is-basededatos has-text-left" @submit.prevent="submit">
                <input type="submit" id="submitbutton" hidden>
                <div class="columns is-vcentered">
                  <div class="column is-4">
                    <label class="label">Color</label>
                  </div>
                  <div class="column">
                    <input v-model="color.title" class="input" type="text" placeholder="Ingrese un título" required>
                  </div>
                </div>
                <div class="columns is-vcentered">
                  <div class="column is-4">
                    <label class="label">Textura</label>
                  </div>
                  <div class="column">
                    <select v-model="color.texture_id" @change="setTexture" class="select" required="">
                      <option v-for="(texture,index) in data.textures" :value="texture.id" :code="texture.code" :hexcode="texture.hexcode" v-html="texture.title"></option>
                    </select>
                  </div>
                </div>
                <div class="columns is-vcentered">
                  <div class="column is-4">
                    <label class="label">Base</label>
                  </div>
                  <div class="column">
                    <select v-model="color.base_id" @change="setBase" class="select" required="">
                      <option v-for="(base,index) in data.bases" :value="base.id" :code="base.code" v-html="'BASE ' + base.code"></option>
                    </select>
                  </div>
                </div>
                <div class="columns is-vcentered">
                  <div class="column is-4">
                    <label class="label">Equipo</label>
                  </div>
                  <div class="column">
                    <select v-model="mac_id" @change="updateMac()" class="select" id="mac">
                      <option v-for="mac in data.machines" :value="mac.id" v-html="mac.title"></option>
                    </select>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <div class="has-action-space">
            <div v-if="selection.texture.code && selection.base.code && mac_id" class="is-weberbox">
              <div class="columns is-vcentered is-dark padless-bottom">
                <div class="column">
                  <img src="/img/logo.png" width="180">
                </div>
                <div class="column is-3 has-text-right">
                  <div class="columns is-vcentered">
                    <div class="column has-text-right is-hidden-mobile">
                      <span class="is-uppercase has-text-centered has-text-weight-semibold">Textura</span>
                    </div>
                    <div>
                      <span class="input has-text-centered has-text-style-normal has-text-weight-semibold" :style="'background-color:#' + selection.texture.hexcode" v-html="selection.texture.code"></span>
                    </div>
                  </div>
                </div>
                <div class="column is-2 has-text-left">
                  <div class="columns is-vcentered">
                    <div class="column has-text-right is-hidden-mobile">
                      <span class="is-uppercase has-text-weight-semibold">Base</span>
                    </div>
                    <div>
                      <span class="input has-text-centered has-text-style-normal has-text-weight-semibold" v-html="selection.base.code"></span>
                    </div>
                  </div>
                </div>
                <div class="column is-1"></div>
              </div>
              <div v-show="data.units" class="is-dark is-cotizacionesrealizadas fadeIn">
                <div class="columns">
                  <div class="column is-hidden-mobile">
                    <div class="input has-background-black has-text-weight-semibold has-text-centered has-text-style-normal is-uppercase">Colorantes</div>
                  </div>
                  <div class="column" v-for="(unit,index3) in data.units">
                    <div class="input has-background-black has-text-weight-semibold has-text-centered has-text-style-normal is-uppercase" v-html="$root.unitLabel(unit)"></div>
                  </div>
                </div>
                <div class="columns" v-for="(colorant,index) in data.colorants">
                  <div class="column">
                    <div class="input has-text-style-normal has-text-centered" :style="'background-color:#' + colorant.hexcode">
                      <span class="has-text-white has-text-weight-semibold" :class="{ 'has-text-black' : colorant.code == 'AXX' || colorant.code == 'KX' }" v-html="colorant.code"></span>
                    </div>
                  </div>
                  <div class="column" v-for="(unit,index2) in data.units">
                    <input class="input" v-model="color.units[colorant.id][unit]" type="number" step="0.001">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="content">
        <div class="columns is-vcentered wp-action-space fadeIn">
          <div class="column">
            <div class="control has-text-centered">
              <!-- router-link class="button" to="/formular-color-y-cotizar">Volver</router-link> &nbsp; -->
              <router-link class="button" to="/formulas-propias">Volver a Fórmulas propias</router-link>
              <button type="button" @click="$('#submitbutton').click()" class="button" :class="{'is-loading' : $root.loading}">Guardar valores</button>
            </div>
          </div>    
        </div>
      </div>
    </div>
  </script>

  <script type="text/x-template" id="formulapropia">
    <div class="has-action-space">
      <div class="container is-padded-top">
        <div class="content hero-system">
          <div class="columns has-text-centered fadeIn">
            <div class="column">
              <h4 class="is-uppercase">Fórmula propia</h4>
              <form class="form is-dark is-condensed has-text-left">
                <div class="columns is-vcentered">
                  <div class="column is-4">
                    <label class="label">Color</label>
                  </div>
                  <div class="column">
                    <input v-model="data.color.title" class="input" type="text" placeholder="Color" readonly>
                  </div>
                </div>
                <div class="columns is-vcentered">
                  <div class="column is-4">
                    <label class="label">Equipo</label>
                  </div>
                  <div class="column">
                    <select v-model="mac_id" @change="updateMac()" class="select" id="mac">
                      <option v-for="mac in data.machines" :value="mac.id" v-html="mac.title"></option>
                    </select>
                  </div>
                </div>                
              </form>
            </div>
          </div>
          <div class="has-action-space">
            <div class="is-weberbox">
              <div class="columns is-dark">
                <div class="column">
                  <img src="/img/logo.png" width="180">
                </div>
                <div class="column is-3">
                  <div class="columns is-vcentered">
                    <div class="column has-text-right is-hidden-mobile">
                      <span class="is-uppercase has-text-centered has-text-weight-semibold">Textura</span>
                    </div>
                    <div class="column is-5">
                      <span class="input has-text-centered has-text-style-normal has-text-weight-semibold" :style="'background-color:#' + data.color.texture_hexcode" v-html="data.color.texture"></span>
                    </div>
                  </div>
                </div>
                <div class="column is-3">
                  <div class="columns is-vcentered">
                    <div class="column has-text-right is-hidden-mobile">
                      <span class="is-uppercase has-text-weight-semibold">Base</span>
                    </div>
                    <div class="column is-5">
                      <span class="input has-text-centered has-text-style-normal has-text-weight-semibold" v-html="data.color.base"></span>
                    </div>
                  </div>
                </div>
              </div>
              <div v-show="data.machine.units" class="is-dark is-cotizacionesrealizadas fadeIn">
                <div class="columns is-hidden-mobile">
                  <div class="column">
                    <div class="input has-background-black has-text-weight-semibold has-text-centered has-text-style-normal is-uppercase">Colorantes</div>
                  </div>
                  <div v-for="(unit,index3) in data.machine.units" class="column">
                    <div class="input has-background-black has-text-weight-semibold has-text-centered has-text-style-normal is-uppercase" v-html="$root.unitLabel(unit)"></div>
                  </div>
                </div>
                <div class="columns" v-for="(formula,index) in data.formulas">
                  <div class="column">
                    <div class="input has-text-style-normal has-text-centered" :style="'background-color:#' + formula.hexcode">
                      <span class="has-text-white has-text-weight-semibold" :class="{ 'has-text-black' : formula.colorant == 'AXX' || formula.colorant == 'KX' }" v-html="formula.colorant"></span>
                    </div>
                  </div>
                  <div class="column" v-for="(amount,index2) in formula.amounts">
                    <div class="input has-text-centered has-text-style-normal" v-html="amount"></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="column has-text-centered">
              <a class="button" @click="download" :colid="data.color.id" :colttl="data.color.title">Imprimir fórmula</a>
            </div>            
          </div>
        </div>  
      </div>
      <div class="content">
        <div class="columns is-vcentered wp-action-space fadeIn">
          <div class="column">
            <div class="control has-text-centered">
              <router-link class="button" to="/formulas-propias/historico">Volver a Histórico</router-link>
            </div>
          </div>    
        </div>
      </div>
    </div>              
  </script>

  <script type="text/x-template" id="cotizacionesrealizadas">
    <div class="has-action-space">
      <div class="container is-padded-top">

        <div v-if="!data.quotes.length" class="content hero-system is-dark fadeIn">
          <div class="columns is-vcentered">
            <div class="column has-text-centered">
              <label class="is-size-5"><span class="has-text-danger">No se encontraron cotizaciones</span></label>
            </div>
          </div>
        </div>
        <div v-if="data.quotes.length" class="content hero-system is-dark is-cotizacionesrealizadas fadeIn">
          <div class="columns is-vcentered">
            <div class="column has-text-right">
              <label class="is-size-5">Cotizaciones realizadas a:</label>
            </div>
            <div class="column has-text-left">
              <select v-model="selection.customer" @change="filterCustomer" class="select" id="customer">
                <option value="">Todos</option>
                <option v-for="customer in data.customers" :value="customer" v-html="customer"></option>
              </select>
            </div>
          </div>
          <div>
            <div class="columns is-vcentered is-hidden-mobile">
              <div class="column has-text-centered">
                <span>Producto</span>
              </div>
              <div class="column has-text-centered">
                <span>Cantidad<br>de baldes</span>
              </div>
              <div class="column has-text-centered">
                <span>Color</span>
              </div>
              <div class="column has-text-centered">
                <span>Fecha</span>
              </div>
              <div class="column has-text-centered">
                <span>Tipo de<br>usuario</span>
              </div>
              <div class="column has-text-centered">
                <span>Informe de<br>cotización</span>
              </div>
            </div>
            <div class="columns" v-for="quote in data.quotes">
              <div class="column">
                <!--div>
                  <pre v-html="quote"></pre>
                </div-->
                <div class="input has-text-weight-semibold has-text-style-normal is-size-6" :style="'background-color:#' + quote.texture_hexcode" v-html="quote.textures"></div>
              </div>
              <div class="column">
                <div class="input is-size-6" v-html="quote.qty"></div>
              </div>
              <div class="column">
                <div class="input is-size-6" v-html="quote.colors"></div>
              </div>
              <div class="column">
                <div class="input is-size-6" v-html="quote.created"></div>
              </div>
              <div class="column">
                <div class="input is-size-6" v-html="quote.consumer"></div>
              </div>
              <div class="column">
                <a class="input has-text-centered has-text-style-normal" @click="more" :id="quote.uuid">Ver más</a>
              </div>
              <hr class="is-hidden-tablet"></div>
            </div>
            <div class="columns is-vcentered fadeIn">
              <div class="column is-4 has-text-right">
                <label>Descargar excel desde el día</label>
              </div>
              <div class="column is-2">
                <input v-model="selection.date_since" class="input" type="text" placeholder="5/5/19" value="7/5/19">
              </div>
              <div class="column has-text-right">
                <label>Hasta el día</label>
              </div>
              <div class="column is-2">
                <input v-model="selection.date_until" class="input" type="text" placeholder="25/5/19" value="8/5/19">
              </div>
              <div class="column is-2">
                <button class="button has-background-success is-uppercase" @click="excel"><span class="has-text-white">Descargar</span></button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="content">
        <div class="columns is-vcentered wp-action-space fadeIn">
          <div class="column">
            <div class="control has-text-centered">
              <router-link class="button" to="/account">Volver al menú principal</router-link>
            </div>
          </div>    
        </div>
      </div>
    </div> 
  </script>

  <script type="text/x-template" id="formularcolor">
    <div class="has-action-space">
      <div class="container is-padded-top fadeIn">
        <div class="content hero-system">
          <div v-if="data.status != 'success'">
            <h4 class="has-text-centered">Debes establecer los costos de los productos primero</h4>
          </div>
          <div v-if="data.status == 'success'">
            <h4 class="has-text-centered">Elige un producto para comenzar</h4>
            <div v-if="data.status == 'success'" class="columns is-multiline has-text-centered is-vcentered is-menu">
              <div v-for="group in data.groups" class="column is-6">
                <div class="columns is-vcentered">
                  <div class="column is-4">
                    <img :src="group[0].pic1_url">
                  </div>
                  <div class="column has-text-centered">
                    <div v-for="item in group" class="is-formularcolor" :class="{ 'selected' : item.id == selected }">
                      <div class="columns is-mobile">
                        <div class="column is-2">
                          <div class="is-formularcolor-sample is-picture is-magnify" magnify-container=".has-action-space" :magnify-image="item.pic2_url"  :style="'background-image:url(' + item.pic2_url + ')'"></div>
                        </div>
                        <div class="column is-10 has-text-left">
                          <a href="#" class="wp-button" @click="select" :json="JSON.stringify(item)" v-html="item.title"></a>
                          <span class="wp-description has-text-left" v-html="item.description"></span>  
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div v-if="data.status == 'success'" class="content">
        <div class="columns is-vcentered wp-action-space fadeIn">
          <div class="column">
            <div class="control has-text-centered">
              <!--router-link class="button" to="/account">Volver</router-link> &nbsp; -->
              <a class="button" @click="submit" :class="{'is-loading' : $root.loading}">Continuar</a>
            </div>
          </div>    
        </div>
      </div>
    </div>    
  </script>

  <script type="text/x-template" id="formularcolordatos">
    <div class="has-action-space">
      <div class="container is-padded-top">
        <div class="content hero-system">
          <div class="columns has-text-centered fadeIn">
            <div class="column">
              <h4>Ingresá tus datos</h4>
              <form class="form is-dark is-condensed has-text-left" @submit.prevent="submit">
                <div class="columns is-vcentered">
                  <div class="column">
                    <label class="label">Ingresá m2 o número de baldes</label>
                  </div>
                  <div class="column is-2">
                    <span class="is-italic">M2</span>
                    <input v-model="m2" @change="updateM2()" @keyup="updateM2()" class="input" type="number" min="1" max="9999" step="0.1" placeholder="M2" autofocus required>
                  </div>
                  <div class="column is-2">
                    <span class="is-italic">Envase</span>
                    <select v-model="pack_id" @change="updatePack()" class="select" id="pack" required>
                      <option value="undefined" selected="selected">Envase</option>
                      <option v-for="pack in data.packs" :value="pack.id" v-html="pack.title"></option>
                    </select>
                  </div>
                  <div class="column is-2">
                    <span class="is-italic">Baldes</span>
                    <input ref="qty"  v-model="qty" @change="updateQty()" @keyup="updateQty()" class="input" type="number" min="0.1" max="999.0" step="0.1" placeholder="Baldes" required>
                  </div>
                </div>
                <div class="columns is-vcentered">
                  <div class="column is-4">
                    <label class="label">Color</label>
                  </div>
                  <div class="column">
                    <select ref="color_id" v-model="quote.color_id" class="select" id="color" required>
                      <option value="" selected>Elegí un color</option>
                      <option v-for="color in data.colors" :value="color.id" v-html="color.title"></option>
                    </select>
                  </div>
                </div>
                <div class="columns is-vcentered">
                  <div class="column is-4">
                    <label class="label">Nombre</label>
                  </div>
                  <div class="column">
                    <input ref="first_name" v-model="quote.first_name" class="input" type="text" placeholder="Ingresá tu nombre" required>
                  </div>
                </div>
                <div class="columns is-vcentered">
                  <div class="column is-4">
                    <label class="label">Apellido</label>
                  </div>
                  <div class="column">
                    <input ref="last_name" v-model="quote.last_name" class="input" type="text" placeholder="Ingresá tu apellido" required>
                  </div>
                </div>
                <div class="columns is-vcentered">
                  <div class="column is-4">
                    <label class="label">Tipo de usuario</label>
                  </div>
                  <div class="column">
                    <select ref="consumer" v-model="quote.consumer" name="consumer" class="select" required>
                      <option value="" selected>Elegí un tipo de usuario</option>         
                      <option v-for="usertype in data.usertypes" :value="usertype.title" v-html="usertype.title"></option>
                    </select>
                  </div>
                </div>
                <div class="columns is-vcentered">
                  <div class="column is-4">
                    <label class="label">Teléfono</label>
                  </div>
                  <div class="column">
                    <input v-model="quote.phone" class="input" type="text" placeholder="Tel.">
                  </div>
                </div>
                <div class="columns is-vcentered">
                  <div class="column is-4">
                    <label class="label">Email</label>
                  </div>
                  <div class="column">
                    <input v-model="quote.email" class="input" type="email" placeholder="@">
                  </div>
                </div>   
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="content">
        <div class="columns is-vcentered wp-action-space fadeIn">
          <div class="column">
            <div class="control has-text-centered">
              <!--router-link class="button" to="/formular-color-y-cotizar">Volver</router-link> &nbsp; -->
              <button type="submit" class="button" @click="submit" :class="{'is-loading' : $root.loading}">Continuar</button>
            </div>
          </div>    
        </div>
      </div>
    </div>
  </script>

  <script type="text/x-template" id="formularcolorcotizacion">
    <div class="has-action-space">
      <div class="container is-padded-top fadeIn">
        <div class="content hero-system">
          <div class="columns has-text-centered">
            <div class="column">
              <h4 class="is-uppercase">Cotización</h4>
              <form class="form is-dark is-condensed has-text-left">
                <input type="hidden" v-model="performance">
                <div class="columns is-vcentered">
                  <div class="column is-4">
                    <label class="label">Cliente</label>
                  </div>
                  <div class="column">
                    <input v-model="quote.customer" class="input" type="text" placeholder="Ingresá tu nombre" readonly>
                  </div>
                </div>

                <div class="columns is-vcentered">
                  <div class="column is-4">
                    <label class="label">Textura</label>
                  </div>
                  <div class="column">
                    <input v-model="quote.textures" class="input" type="text" placeholder="Textura" readonly>
                  </div>
                </div>
                <div class="columns is-vcentered">
                  <div class="column is-4">
                    <label class="label">Color</label>
                  </div>
                  <div class="column">
                    <input v-model="quote.colors" class="input" type="text" placeholder="Color" readonly>
                  </div>
                </div>
                <!--div class="columns is-vcentered">
                  <div class="column is-4">
                    <label class="label">Envase</label>
                  </div>
                  <div class="column">
                    <input v-model="quote.packs" class="input" type="text" placeholder="Envase" required>
                  </div>
                </div-->
                <div class="columns is-vcentered">
                  <div class="column is-4">
                    <label class="label">Nro. de Baldes</label>
                  </div>
                  <div class="column is-2">
                    <input v-model="selection.qty" class="input" type="number" min="1" max="99" placeholder="8" required>
                  </div>
                  <div class="column has-text-right">
                    <label class="label">Tamaño</label>
                  </div>
                  <div class="column">
                    <select v-model="selection.pack_id" class="select" id="pack">
                      <option v-for="pack in packs" :value="pack.id" v-html="pack.title"></option>
                    </select>
                  </div>
                </div>
                <div class="columns is-vcentered">
                  <div class="column is-4">
                    <label class="label">Costo unitario</label>
                  </div>
                  <div class="column">
                    <div class="control" :class="{ 'is-loading' : $root.processing }">
                      <input v-model="quote.unit_price" class="input" type="text" placeholder="$" readonly>
                    </div>
                  </div>
                </div>
                <div class="columns is-vcentered">
                  <div class="column is-4">
                    <label class="label">Costo total</label>
                  </div>
                  <div class="column">
                    <div class="control" :class="{ 'is-loading' : $root.processing }">
                      <input v-model="quote.subtotal" class="input" type="text" placeholder="$" readonly>
                    </div>
                  </div>
                </div>
                <div class="columns is-vcentered">
                  <div class="column is-4">
                    <label class="label">Bonificación (%)</label>
                  </div>
                  <div class="column">
                    <input v-model="selection.discount" class="input" type="number" min="1" max="99" placeholder="%">
                  </div>
                </div>
                <div v-if="quote.subtotal_discount != '0,00'" class="columns is-vcentered">
                  <div class="column is-4">
                    <label class="label">Costo total con Bonificación</label>
                  </div>
                  <div class="column">
                    <input v-model="quote.subtotal_discount" class="input" type="text" placeholder="$" readonly>
                  </div>
                </div>
                <div class="columns is-vcentered">
                  <div class="column is-4">
                    <label class="label">Costo total con IVA</label>
                  </div>
                  <div class="column">
                    <div class="control" :class="{ 'is-loading' : $root.processing }">
                      <input v-model="quote.total" class="input" type="text" placeholder="$" readonly>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="content">
        <div class="columns is-vcentered wp-action-space fadeIn">
          <div class="column">
            <div class="control has-text-centered">
              <button class="button" href="#" @click="download" :uuid="quote.uuid">Imprimir cotización</button> &nbsp;
              <router-link class="button" :to="'/color/' + quote.uuid">Formular</router-link>
            </div>
          </div>    
        </div>
      </div>
    </div>
  </script>

  <script type="text/x-template" id="basededatos">
    <div class="has-action-space">
      <div class="container is-padded-top">
        <div class="content hero-system fadeIn">
          <div class="columns has-text-centered">
            <div class="column">
              <div class="">
                <h4>Base de datos para cotizar</h4>
                <p>Costos AR$/envase</p>
              </div>
              <form class="form is-dark is-basededatos has-text-left" @submit.prevent="submit">
                <div class="columns is-multiline">
                  <div v-for="item in data.colorants" class="column is-mobile is-4">
                    <div class="columns is-vcentered">
                      <div class="column">
                        <label class="label"><span>Colorante</span> <span class="is-uppercase" v-html="item.code"></span></label>
                      </div>
                      <div class="column">
                        <input v-model="inputs.user_colorants[item.id]" class="input" type="number" placeholder="ARS" required>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="">
                  <small>Envase* = 0,946 L</small>
                </div>
                <hr>
                <div class="columns is-vcentered">
                  <div class="column is-2">
                    <label>Envase</label>
                    <select v-model="selection.pack" class="select">
                      <option v-for="(pack,index) in data.packs" :value="pack.id" v-html="pack.title"></option>
                    </select>
                  </div>
                </div>
                <div class="is-condensed">
                  <div class="columns">
                    <div class="column is-7">
                      <div v-for="(pack,pindex) in data.packs" v-show="selection.pack === pack.id" class="fadeIn">
                        <div class="columns">
                          <div class="column is-2"></div>
                          <div v-for="base in data.bases" class="column has-text-centered">
                            <span class="is-uppercase">Base</span> <span class="is-uppercase" v-html="base.title"></span>
                          </div>
                        </div>
                        <div class="columns is-vcentered" v-for="texture in data.textures" v-show="texture.type_id === pack.ttype_id">
                          <div v-html="texture.code" class="column is-2 has-text-weight-semibold has-text-centered" :style="'color:#' + texture.hexcode"></div>
                          <div v-for="base in data.bases" class="column">
                            <input v-model="inputs.user_textures[pack.id][base.id][texture.id]" class="input" type="number" placeholder="ARS" required>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="column bottom-left">
                      <div class="columns is-vcentered">
                        <div class="column">
                          <label class="label"><span>Margen (%)</span></label>
                        </div>
                        <div class="column">
                          <input v-model="inputs.margen" class="input has-background-black" type="number" placeholder="%" required>
                        </div>
                      </div>
                      <div class="columns is-vcentered">
                        <div class="column">
                          <label class="label"><span>IVA (%)</span></label>
                        </div>
                        <div class="column">
                          <input v-model="inputs.iva" class="input has-background-black" type="number" placeholder="%" required>
                        </div>
                      </div>
                      <div class="columns is-vcentered">
                        <div class="column">
                          <label class="label"><span>Fecha lista de precios bases</span></label>
                        </div>
                        <div class="column">
                          <input v-model="data.dates.textures" class="input has-background-info" type="text" placeholder="" required>
                        </div>
                      </div>
                      <div class="columns is-vcentered">
                        <div class="column">
                          <label class="label"><span>Fecha lista de precios colorantes</span></label>
                        </div>
                        <div class="column">
                          <input v-model="data.dates.colorants" class="input has-background-success" type="text" placeholder="" required>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="content">
        <div class="columns is-vcentered wp-action-space fadeIn">
          <div class="column">
            <div class="control has-text-centered">
              <!-- router-link class="button" to="/formular-color-y-cotizar">Volver</router-link> &nbsp; -->
              <button type="button" @click="submit" class="button" :class="{'is-loading' : $root.processing}">Guardar valores</button>
            </div>
          </div>    
        </div>
      </div>
    </div>                
  </script>

  <script type="text/x-template" id="editaccount">
    <div class="hero-body is-pin">
      <div class="container has-text-left">
        <div class="content fadeIn">
          <h3 class="is-uppercase">Mi Cuenta</h3>
          <p class="is-uppercase">Mantiene tus datos al día.</p>
          <div class="badge account-picture">
            <input hidden="true" id="uploads" type="file" @change="onFileChange" name="uploads[]" optional="true" accept="image/*">
            <div class="is-circle picture" v-on:click="clickImage($root.token().id)" :style="'background-image:url(' + $root.token().picture + ')'" data-balloon="Upload a profile is-picture" data-balloon-pos="right"></div>
          </div>
          <form class="form has-text-left" @submit.prevent="submit">
            <div class="field is-horizontal">
              <div class="field-body">
                <div class="field">
                  <label class="label">Nombre</label>
                  <div class="control">
                    <input class="input" name="first_name" type="text" placeholder="John" :value="$root.token().first_name" autofocus required>
                  </div>
                </div>
                <div class="field">
                  <label class="label">Apellido</label>
                  <div class="control">
                    <input class="input" type="text" name="last_name" placeholder="Doe" :value="$root.token().last_name" required>
                  </div>
                </div>
              </div>
            </div>

            <div class="field">
              <label class="label">Email</label>
              <div class="control">
                <input class="input" type="email" name="email" placeholder="johndoe@gmail.com" :value="$root.token().email" required>
              </div>
              <p class="help is-danger is-hidden">El email no es válido</p>
            </div>

            <div class="field is-horizontal">
              <div class="field-body">
                <div class="field">
                  <label class="label">Bio</label>
                  <div class="control">
                    <textarea class="textarea" name="bio" placeholder="I'm John. I love mountains."></textarea>
                  </div>
                </div>
              </div>
            </div>

            <div class="field" v-if="message && message.length">
              <p class="help" :class="messageType" v-html="message"></p>
            </div>

            <div class="field">
              <div class="control">
                <button class="button is-success is-fullwidth" :class="{'is-loading' : $root.loading}">Actualizar</button>
              </div>
            </div>    
          </form>
        </div>
      </div>
    </div>
  </script>

  <script type="text/x-template" id="changepassword">
    <div class="hero-body">
      <div class="container has-text-left">
        <div class="content fadeIn">
          <h3 class="is-uppercase">Change password</h3>
          <p class="is-uppercase">Confirm your password reset.</p>
          <form class="form has-text-left" @submit.prevent="submit">
            <div class="field is-horizontal">
              <div class="field-body">
                <div class="field">
                  <label class="label">Current Password</label>
                  <div class="control">
                    <input class="input" name="password" type="password" placeholder="********" value="" autofocus required>
                  </div>
                </div>
                <div class="field">
                  <label class="label">New Password</label>
                  <div class="control">
                    <input class="input" type="password" name="new_password" placeholder="********" value="" required>
                  </div>
                </div>
              </div>
            </div>
            <div class="field" v-if="message && message.length">
              <p class="help" :class="messageType" v-html="message"></p>
            </div>
            <div class="field">
              <div class="control">
                <button class="button is-success is-fullwidth" :class="{'is-loading' : $root.loading}">Change password</button>
              </div>
            </div>    
          </form>
        </div>
      </div>
    </div>
  </script>

  <script type="text/x-template" id="login">
    <div>
      <div class="container is-padded-top" v-if="$root.token().token">
        <div class="inline-background hero-system fadeIn">
          <div class="content hero fadeIn">
            <h3>Ya tienes una sesión iniciada</h3> 
            <p>¿Qué deseas hacer?</p>
            <div class="columns has-text-centered is-vcentered">
              <div class="column is-hidden-mobile"></div>
              <div class="column is-hidden-mobile"></div>
              <div class="column">
                <button @click="$root.endSessionWithConfirm()" class="button is-text">Cerrar sesión</button>            
              </div>
              <div class="column">
                <a href="/account" class="button is-link">Llevame a Inicio</a>
              </div>
              <div class="column is-hidden-mobile"></div>
              <div class="column is-hidden-mobile"></div>
            </div>        
          </div>
        </div>
      </div>
      <div v-if="!$root.token().token" class="hero">
        <div class="hero-body">
          <div class="container">
            <div class="content columns fadeIn">
              <div class="column is-half is-padded-top">
                <div class="">
                  <h3 class="is-uppercase">Bienvenido</h3>
                </div>
                <form class="form has-text-left" @submit.prevent="submit">
                  <div class="field">
                    <!--label class="label">Email</label-->
                    <div class="control">
                      <input v-model="data.email" class="input" type="email" placeholder="Usuario" autofocus required>
                    </div>
                  </div>
                  <div class="field">
                    <!--label class="label">Contraseña</label-->
                    <div class="control">
                      <input v-model="data.password" class="input" type="password" placeholder="********" required>
                    </div>
                  </div>
                  <div class="field">
                    <div class="control">
                      <button type="submit" class="button is-success is-fullwidth" :class="{'is-loading' : $root.processing}">Ingresar</button>
                    </div>
                  </div>    
                  <div class="field">
                    <div class="control">
                      <a href="/sign-up" class="button is-text">No tengo cuenta</a>
                    </div>
                    <div class="control">
                      <a href="/recover-password" class="button is-text">Olvidé mi clave</a>
                    </div>
                  </div>
                </form>
              </div>
              <div class="column is-half-bg1">  
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </script>

  <script type="text/x-template" id="signup">
    <div>
      <div class="container is-padded-top" v-if="$root.token().token">
        <div class="inline-background hero-system fadeIn">
          <div class="content hero fadeIn">
            <h3>Ya tienes una sesión iniciada</h3> 
            <p>¿Qué deseas hacer?</p>
            <div class="columns has-text-centered is-vcentered">
              <div class="column is-hidden-mobile"></div>
              <div class="column is-hidden-mobile"></div>
              <div class="column">
                <button @click="$root.endSessionWithConfirm()" class="button is-text">Cerrar sesión</button>            
              </div>
              <div class="column">
                <a href="/account" class="button is-link">Llevame a Inicio</a>
              </div>
              <div class="column is-hidden-mobile"></div>
              <div class="column is-hidden-mobile"></div>
            </div>        
          </div>
        </div>
      </div>
      <div v-if="!$root.token().token" class="hero">
        <div class="hero-body">
          <div class="container">
            <div class="content columns fadeIn">
              <div class="column is-half is-padded-top">
                <div class="">
                  <h3 class="is-uppercase">Crear una cuenta</h3>
                </div>
                <form class="form has-text-left" @submit.prevent="submit">
                  <div class="field">
                    <div class="control">
                      <input v-model="data.name" class="input" type="text" placeholder="Nombre completo" autofocus required>
                    </div>
                  </div>
                  <div class="field">
                    <div class="control">
                      <input v-model="data.email" class="input" type="email" placeholder="Email" required>
                    </div>
                  </div>
                  <div class="field">
                    <!--label class="label">Contraseña</label-->
                    <div class="control">
                      <input v-model="data.password" class="input" type="password" placeholder="********" required>
                    </div>
                  </div>
                  <div class="field">
                    <div class="control">
                      <label class="checkbox">
                        <input type="checkbox" v-model="acceptTerms">
                        Acepto los <a href="/terminos-y-condiciones">términos y condiciones de Tusturnosonline APP.</a>
                      </label>
                    </div>
                  </div>
                  <div class="field">
                    <div class="control">
                      <button type="submit" class="button is-success is-fullwidth" :class="{'is-loading' : $root.processing}">Crear cuenta</button>
                    </div>
                  </div>    
                  <div class="field">
                    <div class="control">
                      <a href="/sign-in" class="button is-text">Ya tengo cuenta</a>
                    </div>
                  </div>
                </form>
              </div>
              <div class="column is-half-bg1">  
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </script>

  <script type="text/x-template" id="recoverpassword">
    <div class="hero">
      <div class="hero-body">
        <div class="container">
          <div class="content columns fadeIn">
            <div class="column is-half is-padded-top">
              <h3 class="is-uppercase">Recupera tu cuenta</h3>
              <p class="is-uppercase is-told float">Por favor ingresa tu e-mail.</p>
              <form class="form has-text-left" @submit.prevent="submit">
                <div class="field">
                  <label class="label">Email</label>
                  <div class="control">
                    <input v-model="data.email" class="input" type="email" placeholder="johndoe@gmail.com" autofocus required>
                  </div>
                </div>
                <div class="field">
                  <div class="control">
                    <button type="submit" class="button is-success is-fullwidth" :class="{'is-loading' : $root.processing}">Recuperar contraseña</button>
                  </div>
                </div>    
                <!--div class="field">
                  <div class="control">
                    <a href="/sign-up" class="button is-link">Solicitar una cuenta</a>
                  </div>
                </div-->
              </form>
              <div class="group-control">&nbsp;</div>
              <blockquote class="is-tell">Te enviaremos instrucciones a tu e-mail. </blockquote>
            </div>
            <div class="column is-half-bg1">
            </div>      
          </div>
        </div>
      </div>
    </div>
  </script>

  <script type="text/x-template" id="updatepassword">
    <div class="hero">
      <div class="hero-body">
        <div class="container">
          <div class="content columns fadeIn">
            <div class="column is-half is-padded-top">
              <h3 class="is-uppercase">Recupera tu cuenta</h3>
              <p class="is-uppercase">Actualiza tu contraseña.</p>
              <form class="form has-text-left" @submit.prevent="submit">
                <input type="hidden" name="token" :value="token" />
                <div class="field">
                  <label class="label">Nueva contraseña</label>
                  <div class="control">
                    <input class="input" type="password" name="password" placeholder="********" required>
                  </div>
                </div>
                <div class="field">
                  <div class="control">
                    <button type="submit" class="button is-success is-fullwidth" :class="{'is-loading' : $root.loading}">Actualizar contraseña</button>
                  </div>
                </div>    
                <!--div class="field">
                  <div class="control">
                    <a href="/sign-up" class="button is-link">Solicitar cuenta</a>
                  </div>
                </div-->
              </form>
            </div>
            <div class="column is-half-bg1">
            </div>      
          </div>
        </div>
      </div>
    </div>
  </script>

  <script type="text/x-template" id="contact">
    <div class="hero">
      <div class="hero-body">
        <div class="container">
          <div class="content columns  fadeIn">
            <div class="column is-half is-padded-top">
              <h3 class="is-uppercase">Contacto</h3>
              <p class="is-uppercase">Por favor indica brevemente como podemos ayudarte.</p>
              <p v-if="$root.token().token">
                De: <span class="has-text-success" v-html="$root.token().email"></span>
              </p>
              <form class="form has-text-left" @submit.prevent="submit">
                <div class="field">
                  <select class="select" v-model="data.reason">
                    <option value="">Elige motivo de la consulta</option>
                    <option value="formulaciones">Formulaciones</option>
                    <option value="marketing">Marketing</option>
                  </select>
                </div>

                <div class="field is-horizontal" v-if="!$root.token().token">
                  <div class="field-body">
                    <div class="field">
                      <div class="control">
                        <input v-model="data.first_name" class="input" type="text" placeholder="Nombre" autofocus required>
                      </div>
                    </div>
                    <div class="field">
                      <div class="control">
                        <input v-model="data.last_name" class="input" type="text" placeholder="Apellido" required>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="field" v-if="!$root.token().token">
                  <div class="control">
                    <input v-model="data.email" class="input" type="email" placeholder="Email" autofocus required>
                  </div>
                </div>

                <div class="field">
                  <div class="control">
                    <textarea v-model="data.comment" class="textarea is-success" placeholder="Explique brevemente como podemos ayudarle." required></textarea>
                  </div>
                </div>

                <div class="field">
                  <div class="control">
                    <label class="checkbox">
                      <input type="checkbox" v-model="acceptTerms">
                      Estoy de acuerdo con los <a href="/terminos-y-condiciones">términos y condiciones</a>
                    </label>
                  </div>
                </div>

                <div class="field">
                  <div class="control ">
                    <button type="submit" class="button is-success is-fullwidth" :class="{'is-loading' : $root.loading}">Enviar</button>
                  </div>
                </div>    
              </form>
            </div>
            <div class="column is-half-bg1">
            </div>      
          </div>
        </div>
      </div>
    </div>
  </script>

  <script type="text/x-template" id="opener">
    <div class="container is-padded-top">
      <div class="inline-background hero-system fadeIn">
        <div class="content hero fadeIn">
          <h3>Por favor espere...</h3> 
          <p>Te estamos redirigiendo a ... <span class="is-italic" v-html="url"></span></p>
          <!--div class="field is-grouped">
            <div class="control">
              <a href="/contact#asunto+tecnico" class="button is-link">Contacto</a>              
            </div>
            <div class="control">
              <a href="/" class="button is-link">Llevame a Inicio</a>
            </div>
          </div-->        
        </div>
      </div>
    </div>
  </script>

  <script type="text/x-template" id="slider">
    <div class="slick slick-main">
    [[for posts]]
      <div class="slick-item" style="background-image:url([[:picture]])">
        <h4>[[:title]]</h4>
      </div>
    [[/for]]
    </div>
  </script>

  <script type="text/x-jsrender" id="sessionended">
    <div class="container is-padded-top">
      <div class="inline-background hero-system fadeIn">
        <div class="content hero fadeIn">
          <h3>Tu sesión ha finalizado</h3> 
          <p>Tu sesión ha sido exitosamente finalizada. Vuelve pronto!</p>
          <div class="columns has-text-centered is-vcentered">
            <div class="column is-hidden-mobile"></div>
            <div class="column is-hidden-mobile"></div>
            <div class="column">
              <a href="/sign-in" class="button is-text">Iniciar sesión</a>              
            </div>
            <div class="column">
              <a href="/" class="button is-link">Llevame a Inicio</a>
            </div>
            <div class="column is-hidden-mobile"></div>
            <div class="column is-hidden-mobile"></div>
          </div>        
        </div>
      </div>
    </div>
  </script>

  <script type="text/x-jsrender" id="sessionexpired">
    <div class="container is-padded-top">
      <div class="inline-background hero-system fadeIn">
        <div class="content hero">
          <h3>Tu sesión ha expirado</h3> 
          <p>Tu sesión fue finalizada debido a inactividad. Si deseas continuar en una sesión por favor inicia sesión nuevamente.</p>
          <div class="columns has-text-centered is-vcentered">
            <div class="column is-hidden-mobile"></div>
            <div class="column is-hidden-mobile"></div>
            <div class="column">
              <a href="/sign-in" class="button is-text">Iniciar sesión</a>              
            </div>
            <div class="column">
              <a href="/" class="button is-link">Llevame a Inicio</a>
            </div>
            <div class="column is-hidden-mobile"></div>
            <div class="column is-hidden-mobile"></div>
          </div>        
        </div>
      </div>
    </div>
  </script>

  <script type="text/x-jsrender" id="notfound">
    <div class="container is-padded-top">
      <div class="inline-background hero-system fadeIn">
        <div class="content hero">
          <h3>Página no encontrada</h3> 
          <p>Disculpe. Parece que lo que usted ha solicitado no esta disponible por el momento. Si piensa o siente que esto puede tratarse de un error <a href="/contact">contáctenos</a>. </p>
          <div class="columns has-text-centered is-vcentered">
            <div class="column is-hidden-mobile"></div>
            <div class="column is-hidden-mobile"></div>
            <div class="column">
              <a href="/contact#asunto+tecnico" class="button is-text">Contacto</a>          
            </div>
            <div class="column">
              <a href="/" class="button is-link">Llevame a Inicio</a>
            </div>
            <div class="column is-hidden-mobile"></div>
            <div class="column is-hidden-mobile"></div>
          </div>        
        </div>
      </div>
    </div>
  </script>

  <script type="text/x-jsrender" id="magnifybox">
    <div class="magnify-box is-picture"></div>
  </script>

  <script src="/js/moment-with-locales.min.js"></script>  
  <script src="/js/jquery.min.js"></script>
  <script src="/js/jsrender.min.js"></script>
  <script src="/js/bulma.js"></script>
  <script src="/js/filters.js"></script>
  <script src="/js/scrollmap.js"></script>
  <script src="/js/vue.min.js" type="text/javascript"></script>  
  <script src="/js/vue-router.js" type="text/javascript"></script>  
  <script src="/js/vue-resource.min.js" type="text/javascript"></script>  
  <script src="/js/routes.js" type="text/javascript"></script>  
</body>
</html>