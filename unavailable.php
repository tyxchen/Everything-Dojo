<!--
<img src="images/unavailable.png" alt="We're sad, too." title="We're sad, too." />
<p>We're sorry, the page you are trying to access is under development or unavailable for some reason. We'll try to fix it as soon as possible. To make you feel better, here's a present:</p>
<img src="images/present.png" alt="A WILD KITTY APPEARS!" title="If you don't like cats, imagine it's a dog instead." />
-->

<div id="main-content">
  <!-- EvDo logo svg here -->
  <img id="main-content-logo" alt="Everything Dojo Logo" width="128" height="128" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiIHN0YW5kYWxvbmU9InllcyIgPz4KPHN2ZyB3aWR0aD0iNjQiIGhlaWdodD0iNjQiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6c3ZnPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxnPgogIDwhLS0gRSAtLT4KICA8cGF0aCBzdHlsZT0iZmlsbDojZDU1NGNiO3N0cm9rZTpub25lOyIgZD0iTTAgMEwwIDI5TDI5IDI5TDI5IDBMMCAweiIvPgogIDxwYXRoIHN0eWxlPSJmaWxsOiNmZGZlZmY7c3Ryb2tlOm5vbmU7IiBkPSJNOSA2TDkgMjNMMTkgMjNMMTkgMjJMMTAgMjJMMTAgMTVMMTcuNSAxNUwxNy41IDE0TDEwIDE0TDEwIDdMMTkgN0wxOSA2eiIvPgogIDwhLS0gViAtLT4KICA8cGF0aCBzdHlsZT0iZmlsbDojNTdjNjM5O3N0cm9rZTpub25lOyIgZD0iTTM1IDBMMzUgMjlMNjQgMjlMNjQgMEwzNSAweiIvPgogIDxwYXRoIHN0eWxlPSJmaWxsOiNmZGZlZmY7c3Ryb2tlOm5vbmU7IiBkPSJNNDIgNkw0OSAyM0w1MCAyM0w1NyA2TDU1LjcgNkw0OS41IDIxLjdMNDMuMyA2eiIvPgogIDwhLS0gRCAtLT4KICA8cGF0aCBzdHlsZT0iZmlsbDojZmY2ZDAwO3N0cm9rZTpub25lOyIgZD0iTTAgMzVMMCA2NEwyOSA2NEwyOSAzNUwwIDM1eiIvPgogIDxwYXRoIHN0eWxlPSJmaWxsOiNmZGZlZmY7c3Ryb2tlOm5vbmU7IiBkPSJNOCA0MUw4IDU4TDE0IDU4QzIzLjc0NzEgNTcuNjc3MyAyMy42NTggNDEuMzIwNSAxNCA0MXoiLz4KICA8cGF0aCBzdHlsZT0iZmlsbDojZmY2ZDAwO3N0cm9rZTpub25lOyIgZD0iTTkgNDJMOSA1N0wxNCA1N0MyMi4zNDcxIDU2LjQ3NzMgMjIuMjU4IDQyLjUyMDUgMTQgNDJ6Ii8+CiAgPCEtLSBPIC0tPgogIDxwYXRoIHN0eWxlPSJmaWxsOiM1MDk5ZmY7c3Ryb2tlOm5vbmU7IiBkPSJNMzUgMzVMMzUgNjRMNjQgNjRMNjQgMzVMMzUgMzV6Ii8+CiAgPHBhdGggc3R5bGU9ImZpbGw6I2ZkZmVmZjtzdHJva2U6bm9uZTsiIGQ9Ik00Ny42MDg4IDQxLjU0NjlDMzcuNTUyOSA0My44MzgzIDQyLjA1MjcgNjIuMDg2NCA1My40NDE0IDU2Ljg4MTJDNjAuNTg2MiA1Mi41NTEzIDU2LjcyNTQgMzkuMjIxNSA0Ny42MDg4IDQxLjU0Njl6Ii8+CiAgPHBhdGggc3R5bGU9ImZpbGw6IzUwOTlmZjtzdHJva2U6bm9uZTsiIGQ9Ik00Ny4xMDg4IDQyLjc0NjlDMzkuNTUyOSA0NS44MzgzIDQzLjU1MjcgNTkuNDg2NCA1MS45NDE0IDU2LjM4MTJDNTkuNTg2MiA1My41NTEzIDU1LjcyNTQgMzkuMjIxNSA0Ny4xMDg4IDQyLjc0Njl6Ii8+CjwvZz4KPC9zdmc+Cg==" />
  <?php if (basename($_SERVER['PHP_SELF']) == "index.php"){ ?>
    <h1>Sorry, Everything Dojo is currently unavailable.</h1>
    <h2>The site is undergoing an upgrade. <b>We apologize for the inconvenience.</b></h2>
  <?php } else if (basename($_SERVER['PHP_SELF']) == "unavailable.php"){ ?>
    <h1>Sorry, the page you requested is currently unavailable.</h1>
    <h2>Either the page you were trying to access is under development or unavailable for some reason. Please report this to our Staff <a href="contact.php">here</a> and we'll try to fix it as soon as possible. <b>We apologize for the inconvenience.</b></h2>
  <?php } else {?>
    <h1>Sorry, but we don't know what's happening.</h1>
    <h2>So here's a redundant message instead. <b>We apologize for the inconvenience.</b></h2>
  <?php } ?>
</div>

<style>
  @import url(http://fonts.googleapis.com/css?family=Lato:400,700);
  @-webkit-keyframes fullSpin{
    0%{
      -webkit-transform: rotateY(0deg) rotateX(0deg);
      transform: rotateY(0deg) rotateX(0deg);
    }
    50%{
      -webkit-transform: rotateY(360deg) rotateX(0deg);
      transform: rotateY(360deg) rotateX(0deg);
    }
    100%{
      -webkit-transform: rotateY(360deg) rotateX(360deg);
      transform: rotateY(360deg) rotateX(360deg);
    }
  }
  @keyframes fullSpin{
    0%{
      -webkit-transform: rotateY(0deg);
      transform: rotateY(0deg);
    }
    100%{
      -webkit-transform: rotateY(360deg);
      transform: rotateY(360deg);
    }
  }
  html, body{
    overflow: hidden;
  }
  body{
    width: 100%;
    height: 100%;
    margin: 0;
    padding: 0;
    background-color: rgba(0, 0, 0, 1);
    color: rgba(255, 255, 255, 1);
    font-family: Lato, sans-serif;
  }
  h1{
    font-size: 3em;
    font-weight: 700;
  }
  h2{
    font-size: 1em;
    font-weight: 400;
  }
  a {
    color: #0BDD50;
    text-decoration: none;
    outline: none;
    cursor: pointer;
  }

  a:hover { color: #18D04C; }
  #main-content{
    width: 80%;
    height: 80%;
    text-align:center;
    margin: 10%;
  }
  #main-content-logo{
    width: 40%;
    height: 40%;
    min-width: 128px;
    min-height: 128px;
    -webkit-animation: fullSpin 8000ms ease infinite;
    animation: fullSpin 10000ms ease infinite;
    -webkit-transform-style: preserve-3d;
    transform-style: preserve-3d;
  }
</style>
