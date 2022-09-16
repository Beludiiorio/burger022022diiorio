@extends("web.plantilla")
@section('contenido')
  <!-- about section -->

  <section class="about_section layout_padding">
    <div class="container  ">

      <div class="row">
        <div class="col-md-6 ">
          <div class="img-box">
            <img src="web/images/burgertasty.png" alt="">
          </div>
        </div>
        <div class="col-md-6">
          <div class="detail-box">
            <div class="heading_container">
              <h2>
              La Monumental Burger
              </h2>
            </div>
            <p>
            La Monumental Burger es una franquicia de restaurantes de comida rápida Argentina con sedes en CABA.​ Sus principales productos son las distintas hamburguesas para todos los gustos, las papas fritas con sus distintas versiones y las bebidas.
            </p>
            <a href="">
              Leer más
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- end about section -->
  
  <!-- client section -->

  <section class="client_section pt-5">
    <div class="container">
      <div class="heading_container heading_center psudo_white_primary mb_45">
        <h2>
          Reseñas de nuestros clientes...
        </h2>
      </div>
      <div class="carousel-wrap row ">
        <div class="owl-carousel client_owl-carousel">
          <div class="item">
            <div class="box">
              <div class="detail-box">
                <p>
                El lugar es muy grande, esta bien distribuido, la comida riquísima y por sobre todas las cosas y no menos importante, se nota la limpieza y el cuidado con el que trabajan.
                
                
                </p>
                <h6>
                  Natalia Figueroa
                </h6>
                <p>
                  Clienta
                </p>
              </div>
              <div class="img-box">
                <img src="web/images/chicareseña.jpg" alt="" class="box-img">
              </div>
            </div>
          </div>
          <div class="item">
            <div class="box">
              <div class="detail-box">
                <p>
                El personal muy amable y atento en todo momento, la comida es muy sabrosa, de las mejores hamburguesas que he probado, súper recomdable! Sin dudas es un lugar al que volveré.
                </p>
                <h6>
                  Francisco Rodríguez
                </h6>
                <p>
                  Cliente
                </p>
              </div>
              <div class="img-box">
                <img src="web/images/hombrereseña.jpg" alt="" class="box-img">
              </div>
            </div>
          </div>
          <div class="item">
            <div class="box">
              <div class="detail-box">
                <p>
                Primera vez que iba, la verdad el lugar es precioso y la comida espectacular, la zona está muy bien ubicada. Tienen sillitas para bebés y jueguitos para los chicos un poco más grandes también.
                </p>
                <h6>
                  Ana María Polo
                </h6>
                <p>
                  Clienta
                </p>
              </div>
              <div class="img-box">
                <img src="web/images/clienta4.jpg" alt="" class="box-img">
              </div>
            </div>
          </div>
          <div class="item">
            <div class="box">
              <div class="detail-box">
                <p>
                Bueno, qué decir... el lugar me encantó, algo a destacar son sus pechugitas!! deliciosas y ni hablar de sus papas cargadas. Gracias por su atención!
                </p>
                <h6>
                  Pablo Morales
                </h6>
                <p>
                  Cliente
                </p>
              </div>
              <div class="img-box">
                <img src="web/images/cliente5.jpg" alt="" class="box-img">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>





  </section>
  <!-- end client section -->
  <section class="book_section layout_padding-bottom">
    <div class="container">
      <div class="heading_container text-center">
        <h2>
          ¡Trabaja con nosotros!
        </h2>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="form_container">
            <form method="POST" action="" enctype="multipart/form-data">
               <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
              <div>
                <input type="text" class="form-control" placeholder="Nombre y Apellido" name="txtNombre"/>
              </div>
              <div>
                <input type="text" class="form-control" placeholder="Número de Teléfono" name="txtTelefono" />
              </div>
              <div>
                <input type="email" class="form-control" placeholder="Correo electrónico" name="txtCorreo" />
              </div>
               <div>
                <label for="TxtFechaNac">Mensaje:</label>
                <textarea name="txtMensaje" id="txtMensaje" class="form-control"></textarea>
              </div>
              <div>
                <label for="archivo" class="d-block">Adjunta tu CV:</label>
                <input type="file" name="archivo" id="archivo">
              </div>
              <div class="btn_box text-center">
                <button type="submit">
                  Enviar
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection