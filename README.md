<h1>Proyecto Laravel 8.6 con Laravel Mix y Bootstrap</h1>

<p>
Este proyecto está construido con Laravel 8.6 e incluye el sistema de autenticación proporcionado por Laravel. Además, utiliza <strong>Laravel Mix</strong> para la compilación de assets y <strong>Bootstrap</strong> para el diseño frontend.
</p>

<h2>Requisitos previos</h2>
<p>
Antes de iniciar, asegúrate de tener instalados los siguientes requisitos en tu servidor o entorno local:
</p>
<ul>
  <li><strong>Servidor web:</strong> Nginx o Apache</li>
  <li><strong>PHP:</strong> Versión 8.1 o superior</li>
  <li><strong>Composer:</strong> Administrador de dependencias de PHP</li>
  <li><strong>npm:</strong> Administrador de paquetes de Node.js</li>
</ul>

<h2>Instalación del proyecto</h2>
<p>Sigue los siguientes pasos para instalar y configurar el proyecto en tu entorno local o en un servidor:</p>

<ol>
  <li><strong>Clonar el repositorio:</strong>
    <pre><code>git clone https://github.com/joenpusa/JAC_LaravelMVC.git
    </code></pre>
  </li>

  <li><strong>En el directorio del proyecto instalar dependencias de PHP con Composer:</strong>
    <pre><code>composer install</code></pre>
  </li>

  <li><strong>Instalar dependencias de JavaScript con npm:</strong>
    <pre><code>npm install</code></pre>
  </li>

  <li><strong>Compilar assets con Laravel Mix:</strong>
    <pre><code>npm run dev</code></pre>
    <p>O para compilación optimizada en producción:</p>
    <pre><code>npm run prod</code></pre>
  </li>

  <li><strong>Configurar el archivo <code>.env</code>:</strong>
    <p>Copia el archivo <code>.env.example</code> y renómbralo como <code>.env</code>:</p>
    <pre><code>cp .env.example .env</code></pre>
    <p>Luego, configura las variables de entorno necesarias (base de datos, URL, etc.).</p>
  </li>

  <li><strong>Generar la clave de la aplicación:</strong>
    <pre><code>php artisan key:generate</code></pre>
  </li>

  <li><strong>Configurar la base de datos:</strong>
    <p>Asegúrate de tener una base de datos creada y configurada en el archivo <code>.env</code>. Luego, ejecuta las migraciones:</p>
    <pre><code>php artisan migrate</code></pre>
  </li>

  <li><strong>Iniciar el servidor local de Laravel:</strong>
    <pre><code>php artisan serve</code></pre>
    <p>Si estás utilizando Nginx o Apache, asegúrate de configurar correctamente el servidor web para apuntar al directorio <code>public/</code> del proyecto.</p>
  </li>
</ol>

<h2>Autenticación</h2>
<p>
Este proyecto incluye el sistema de autenticación proporcionado por Laravel. Una vez instaladas las dependencias y migraciones, puedes acceder al sistema de login y registro predeterminado en las rutas:
</p>
<ul>
  <li><code>/login</code></li>
  <li><code>/register</code></li>
</ul>

<h2>Compilación de assets con Laravel Mix</h2>
<p>
Laravel Mix facilita la compilación de archivos CSS y JS. Se utiliza <strong>Bootstrap</strong> como framework CSS, y puedes personalizar y compilar los assets según tus necesidades.
</p>
<p>
Para ver más detalles sobre cómo personalizar las compilaciones, revisa el archivo <code>webpack.mix.js</code>.
</p>
