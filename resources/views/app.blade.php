<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="es-ES">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <title>TusTurnosOnline.com</title>
  <link rel="home" href="/">
  <!-- Page Meta -->
  <meta name="title" content="TusTurnosOnline.com">
  <meta name="descriptionsession-" content="Obtené tus turnos con agilidad en TusTurnosOnline.com-">
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
  <link rel="stylesheet" href="/css/source-sans-pro.css">
</head>
<body>
  <div id="app">
    <div v-show="$root.loading" class="spinner-outer fadeIn">
      <div class="spinner" data-layer="4">
        <div class="spinner-container">
          <div class="spinner-rotator">
            <div class="spinner-left">
              <div class="spinner-circle"></div>
            </div>
            <div class="spinner-right">
              <div class="spinner-circle"></div>
            </div>
          </div>
        </div>
        <div class="spinner-message" v-html="$root.message"></div>
      </div>
    </div>

    <div v-show="!$root.loading" class="hidden-loading">
      <div class="menu">
        <div class="menu-container columns">
          <div class="column has-text-left">
            <a class="menu-logo" @click="homeClick" href="#">
              <img src="/img/logo.png" alt="Tusturnosonline">
            </a>
          </div>

          <div class="column menu-primary">
            <div class="menu-bg"></div>
            <div class="menu-burger">☰</div>
          </div>

          <div class="menu-items">
            <a href="/"><img src="/img/logo.png"></a>
            <div v-if="$root.token().token" class="menu-links has-text-left">
              <a href="/account"><span>🏁</span> Menú Principal</a>
              <a href="/clientes"><span>👥</span> CRM Cliente</a>
              <a href="/atributos"><span>🔖</span> CRM Atributo</a>
              <a href="/carga"><span>📙</span> Carga</a>
              <hr>
              <a href="/edit"><span>👤</span> Mi cuenta</a>
              <a href="/password"><span>🔑</span> Cambiar contraseña</a>
              <hr>
            </div>
            <div class="menu-links">
              <a v-for="navitem in $root.navitems" :href="navitem.slug" v-html="navitem.title"></a>
            </div>
            <a href="#" v-if="$root.token().token" @click="$root.endSessionWithConfirm()" class="button">Cerrar sesión</a>
            <a href="/sign-in" v-if="!$root.token().token" class="button">Iniciar sesión</a>
          </div>    
        </div>
      </div>
      
      <div class="content is-section-text fadeIn columns is-vcentered">
        <div class="has-text-left">
          <h4 id="title"></h4>
          <p id="info"></p>
        </div>
      </div>

      <keep-alive exclude="account,clientes,cliente,atributos,atributo,contact,carga">
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
                <h4>CRM<br>Cliente</h4>
              </a>
            </div>
            <div class="column">
              <a href="/atributos">
                <div class="item">
                  <span class="is-size-2">🔖</span>
                </div>
                <h4>CRM<br>Atributo</h4>
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
                <h4>Mi cuenta</h4>
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

  <script type="text/x-template" id="clientes">
    <div class="has-action-space">
      <div class="container is-padded-top">
        <div class="content hero-system is-dark fadeIn">
          <div class="has-text-centered is-grid">
            <div class="columns">
              <div class="column">
                <input v-model="item.nom" type="text" class="input" />
              </div>
              <div class="column">
                <a class="input has-text-centered has-background-success has-text-white has-text-style-normal" @click="add">Agregar</a>
              </div>
            </div>
            <div class="columns" v-for="item in data">
              <div class="column is-6">
                <router-link :to="'/clientes/' + item.id">
                  <div class="input" v-html="item.nom"></div>
                </router-link>
              </div>
              <div class="column">
                <router-link :to="'/carga#'+item.id" class="input has-text-centered has-text-white has-background-success has-text-style-normal">Ver mas</a>
              </div>
              <div class="column">
                <a class="input has-text-centered has-background-danger has-text-white has-text-style-normal" @click="remove" :id="item.id">Eliminar</a>
              </div>
              <hr class="is-hidden-tablet" />
            </div>
          </div>
        </div>
      </div>
      <div class="content">
        <div class="columns is-vcentered wp-action-space fadeIn">
          <div class="column">
            <div class="control has-text-centered">
              <router-link class="button" to="/account">🏁 Menú Principal</router-link>
              <router-link class="button" to="/atributos">🔖 CRM Atributo</router-link>
            </div>
          </div>    
        </div>
      </div>
    </div>    
  </script>

  <script type="text/x-template" id="cliente">
    <div class="has-action-space">
      <div class="container is-padded-top">
        <div class="content hero-system fadeIn">
          <div class="columns has-text-centered">
            <div class="column">
              <div class="">
                <h4>Cliente</h4>
              </div>
              <!--pre v-html="data.colorants"></pre-->
              <form class="form is-dark is-condensed is-basededatos has-text-left" @submit.prevent="submit">
                <input type="submit" id="submitbutton" hidden>
                <div class="columns is-vcentered">
                  <div class="column is-4">
                    <label class="label">Nombre</label>
                  </div>
                  <div class="column">
                    <input v-model="data.nom" class="input" type="text" placeholder="Ingrese un nombre" required>
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
              <router-link class="button" to="/account">🏁 Menú Principal</router-link>
              <button type="button" @click="$('#submitbutton').click()" class="button" :class="{'is-loading' : $root.loading}">💾 Guardar valores</button>
            </div>
          </div>    
        </div>
      </div>
    </div>
  </script>

  <script type="text/x-template" id="atributos">
    <div class="has-action-space">
      <div class="container is-padded-top">
        <div class="content hero-system is-dark fadeIn">
          <div class="has-text-centered is-grid">
            <!--div class="columns is-hidden-mobile">
              <div class="column is-6 has-text-centered">Nombre</div>
              <div class="column has-text-centered">Tipo dato</div>
              <div class="column"></div>
            </div-->
            <div class="columns">
              <div class="column is-6">
                <input v-model="item.nom" type="text" class="input" />
              </div>
              <div class="column">
                <select v-model="item.tipo" class="input select">
                  <option v-for="item in $root.tipodatos" :value="item.nom" v-html="item.val"></option>
                </select>
              </div>
              <div class="column">
                <a class="input has-text-centered has-background-success has-text-white has-text-style-normal" @click="add">Agregar</a>
              </div>
            </div>
            <div class="columns" v-for="item in data">
              <div class="column is-6">
                <router-link :to="'/atributos/' + item.id">
                  <div class="input" v-html="item.nom"></div>
                </router-link>
              </div>
              <div class="column">
                <div class="input" v-html="item.tipo"></div>
              </div>
              <div class="column">
                <a class="input has-text-centered has-background-danger has-text-white has-text-style-normal" @click="remove" :id="item.id">Eliminar</a>
              </div>
              <hr class="is-hidden-tablet" />
            </div>
          </div>
        </div>
      </div>
      <div class="content">
        <div class="columns is-vcentered wp-action-space fadeIn">
          <div class="column">
            <div class="control has-text-centered">
              <router-link class="button" to="/account">🏁 Menú Principal</router-link>
              <router-link class="button" to="/clientes">👥 CRM Cliente</router-link>
            </div>
          </div>    
        </div>
      </div>
    </div>    
  </script>

  <script type="text/x-template" id="atributo">
    <div class="has-action-space">
      <div class="container is-padded-top">
        <div class="content hero-system fadeIn">
          <div class="columns has-text-centered">
            <div class="column">
              <div class="">
                <h4>Atributo</h4>
              </div>
              <!--pre v-html="data.colorants"></pre-->
              <form class="form is-dark is-condensed is-basededatos has-text-left" @submit.prevent="submit">
                <input type="submit" id="submitbutton" hidden>
                <div class="columns is-vcentered">
                  <div class="column">
                    <label class="label">Nombre</label>
                  </div>
                  <div class="column">
                    <input v-model="data.nom" class="input" type="text" placeholder="Ingrese un atributo" required>
                  </div>
                  <div class="column">
                    <select v-model="data.tipo" class="input select">
                      <option v-for="item in $root.tipodatos" :value="item.nom" v-html="item.val"></option>
                    </select>
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
              <router-link class="button" to="/account">🏁 Menú Principal</router-link>
              <button type="button" @click="$('#submitbutton').click()" class="button" :class="{'is-loading' : $root.loading}">💾 Guardar valores</button>
            </div>
          </div>    
        </div>
      </div>
    </div>
  </script>

  <script type="text/x-template" id="carga">
    <div class="container is-padded-top">
      <div class="content hero-system fadeIn">
        <div class="columns is-carga is-centered is-vcentered">
          <div class="column is-4">
            <form class="form is-dark has-text-left">
              <input type="submit" id="submitbutton" hidden>
              <div class="columns is-vcentered">
                <div class="column">
                  <input v-model="selection.nom" @keyup="buscarCliente" @focus="focusNom" @blur="blurNom" class="input" :class="{'is-loading' : $root.processing}" type="text" placeholder="Ingrese un cliente" required>
                  <div v-show="suggests.length" class="list is-hoverable">
                    <a class="list-item" v-for="(item,index) in suggests" @click="more(item)">
                      <span v-html="item.nom"></span>
                    </a>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="column is-8">
            <form v-show="item.id" class="form is-dark has-text-left" @submit.prevent="submit">
              <input type="submit" id="submitbutton" hidden>
              <div class="columns is-vcentered">
                <div class="column">
                  <select v-model="selection.atributo_id" class="input select" id="atributo">
                    <option value="">Seleccione atributo</option>
                    <option v-for="item in $root.atributos" :value="item.id" v-html="item.nom"></option>
                  </select>
                </div>
                <div class="column">
                  <input v-model="selection.valor" class="input" type="text" :placeholder="placeholder" required>
                </div>
                <div class="column">
                  <button type="submit" class="input has-background-success has-text-white has-text-centered" :class="{'is-loading' : $root.processing}">Agregar</button>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div v-show="item.id" class=" has-text-centered is-dark is-grid is-vcondensed">
          <div class="columns is-centered is-vcentered" v-for="item in data">
            <div class="column">
              <div class="input" v-html="item.atributo.nom"></div>
            </div>
            <div class="column">
              <input v-model="item.valor" class="input" type="text" @focus="focusAtributo" @blur="blurAtributo">
            </div>
            <div class="column">
              <div class="columns">
                <div class="column is-hidden">
                  <a class="input has-text-centered has-text-white has-background-success has-text-style-normal" @click="updateAtributo(item)">Guardar</a>
                </div>
                <div class="column">
                  <a class="input has-text-centered has-text-white has-background-danger has-text-style-normal" @click="removeAtributo" :id="item.id">Eliminar</a>
                </div>
              </div>
            </div>
            <hr class="is-hidden-tablet" />
          </div>
        </div>
      </div>
    </div>
  </script>

  <script type="text/x-template" id="editaccount">
    <div class="hero-body is-pin">
      <div class="container has-text-left">
        <div class="columns">
          <div class="column is-2">
            <div class="badge account-picture">
              <input hidden="true" id="uploads" type="file" @change="onFileChange" name="image" optional="true" accept="image/*">
              <div class="is-circle picture" v-on:click="clickImage()" :style="'background-image:url(/upload/' + data.foto + ')'"></div>
            </div>
          </div>
          <div class="column">
            <form class="form has-text-left" @submit.prevent="submit">
              <div class="field is-horizontal">
                <div class="field-body">
                  <div class="field">
                    <label class="label">Nombre</label>
                    <div class="control">
                      <input v-model="data.name" class="input" type="text" placeholder="Nombre"  autofocus required>
                    </div>
                  </div>
                </div>
              </div>

              <div class="field">
                <label class="label">Email</label>
                <div class="control">
                  <input v-model="data.email" class="input" type="email" placeholder="micuenta@gmail.com" required>
                </div>
                <p class="help is-danger is-hidden">El email no es válido</p>
              </div>

              <!--div class="field is-horizontal">
                <div class="field-body">
                  <div class="field">
                    <label class="label">Bio</label>
                    <div class="control">
                      <textarea v-model="data.first_name" class="textarea" name="bio" placeholder="Escribe tu biografía aquí."></textarea>
                    </div>
                  </div>
                </div>
              </div-->

              <div class="field">
                <div class="control">
                  <button class="button is-success is-fullwidth" :class="{'is-loading' : $root.loading}">💾 Actualizar</button>
                </div>
              </div>    
              <div class="field">
                <div class="control">
                  <a href="/password" class="button is-text">🔑 Cambiar contraseña</a>
                </div>
                <div class="control">
                  <a href="/account" class="button is-text">🏁 Menú Principal</a>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </script>

  <script type="text/x-template" id="changepassword">
    <div class="hero-body is-pin">
      <div class="container has-text-left">
        <div class="content fadeIn">
          <h3 class="is-uppercase">🔑 Cambiar contraseña</h3>
          <p class="is-uppercase">Ingresa tu actual contraseña seguida de la nueva contraseña.</p>
          <form class="form has-text-left" @submit.prevent="submit">
            <div class="field is-horizontal">
              <div class="field-body">
                <div class="field">
                  <label class="label">Contraseña actual</label>
                  <div class="control">
                    <input v-model="data.password" class="input" type="password" placeholder="********" value="" autofocus required>
                  </div>
                </div>
                <div class="field">
                  <label class="label">Nueva contraseña</label>
                  <div class="control">
                    <input v-model="data.new_password" class="input" type="password" placeholder="********" value="" required>
                  </div>
                </div>
              </div>
            </div>
            <div class="field">
              <div class="control">
                <button type="submit" class="button is-success is-fullwidth" :class="{'is-loading' : $root.loading}">Change password</button>
              </div>
            </div>
            <div class="field">
              <div class="control">
                <a href="/edit" class="button is-text">👤 Mi Cuenta</a>
              </div>
              <div class="control">
                <a href="/account" class="button is-text">🏁 Menú Principal</a>
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
            <h3>Tu sesión se encuentra activa.</h3> 
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
                      <a href="/recover-password" class="button is-text">😱 Olvidé mi clave</a>
                    </div>
                  </div>
                </form>
              </div>
              <div class="column is-half-bg1">  
                <div class="is-half-container">
                  <h1 class="has-text-berry">Ahorra tiempo y costos gestionando online</h1>
                  <p class="has-text-berry"><a href="/sign-up" class="has-text-berry">Consigue tu cuenta en <em>Tusturnosonline APP</em> ahora.</a>.</p>
                </div>
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
            <h3>Ya tienes una sesión activa</h3> 
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
                <div class="is-half-container">
                  <h1 class="has-text-berry">Casos de estudio</h1>
                  <p class="has-text-berry"><a href="/sign-up" class="has-text-berry">Echa un vistazo a los <a href="/casosdeestudio">casos de estudio</a> que seleccionamos para vos.  Consigue tu cuenta en <em>Tusturnosonline APP</em> ahora.</a>.</p>
                </div>
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
              <h3 class="is-uppercase">Respira profundo. 😃 <br>Ahora recupera tu cuenta. </h3>
              <p class="is-uppercase is-told float">Por favor ingresa tu e-mail.</p>
              <form class="form has-text-left" @submit.prevent="submit">
                <div class="field">
                  <label class="label">Email</label>
                  <div class="control">
                    <input v-model="data.email" class="input" type="email" placeholder="micuenta@gmail.com" autofocus required>
                  </div>
                </div>
                <div class="field">
                  <div class="control">
                    <button type="submit" class="button is-success is-fullwidth" :class="{'is-loading' : $root.processing}">Recuperar cuenta</button>
                  </div>
                </div>    
                <!--div class="field">
                  <div class="control">
                    <a href="/sign-up" class="button is-link">Solicitar una cuenta</a>
                  </div>
                </div-->
              </form>
              <div class="group-control">&nbsp;</div>
              <blockquote class="is-tell">Te enviaremos instrucciones a tu e-mail. Por favor síguelas con atención.  </blockquote>
            </div>
            <div class="column is-half-bg1">
              <div class="is-half-container">
                <h1 class="has-text-berry">Get you fast banana today</h1>
                <p class="has-text-berry"><a href="/sign-up" class="has-text-berry">Registra tu cuenta hoy de forma gratuita.</a>.</p>
              </div>
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
              <p class="is-uppercase">💾 Actualiza tu contraseña.</p>
              <form class="form has-text-left" @submit.prevent="submit">
                <input type="hidden" name="token" :value="token" />
                <div class="field">
                  <label class="label">Nueva contraseña</label>
                  <div class="control">
                    <input v-model="data.password" class="input" type="password" placeholder="********" required>
                  </div>
                </div>
                <div class="field">
                  <div class="control">
                    <button type="submit" class="button is-success is-fullwidth" :class="{'is-loading' : $root.loading}">💾 Actualizar contraseña</button>
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
              <div class="is-half-container">
                <h1 class="has-text-berry">Empieza a trabajar profesionalmente hoy</h1>
                <p class="has-text-berry"><a href="/sign-up" class="has-text-berry">Consigue tu cuenta en <em>Tusturnosonline APP</em> ahora.</a>.</p>
              </div>
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
                  <select class="input select" v-model="data.reason">
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
              <div class="is-half-container">
                <h1 class="has-text-berry">¿Estás cansado de los paradigmas antiguos de sofware?</h1>
                <p><a href="/sign-up" class="has-text-berry">Consigue tu cuenta en <em>Tusturnosonline APP</em> ahora.</a>.</p>
              </div>
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
  <script src="/js/exif.js"></script>
  <script src="/js/binaryajax.js"></script>
  <script src="/js/vue.min.js" type="text/javascript"></script>  
  <script src="/js/vue-router.js" type="text/javascript"></script>  
  <script src="/js/vue-resource.min.js" type="text/javascript"></script>  
  <script src="/js/routes.js" type="text/javascript"></script>  
</body>
</html>