<template>
  <div class="home">
    <img
      id="home__image"
      alt="Vue logo"
      style="position: relative; top: 0; left: 0"
      width="100%"
      src="../assets/home.jpg"
    />
    <div class="home__content">
      <h1 class="home__title">مرحبا بكم في الموقع الرسمي</h1>
      <div class="separator separator-primary"></div>
      <h1 class="text-weight-bold">لفوج جرجيس للكشافة التونسية</h1>
      <a href="#events" class="btn btn-primary btn-lg text-light mt-3"
        >الاطلاع على المزيد</a
      >
    </div>
    <div class="events__content" id="events">
      <h1 class="events_title">الأنشطة</h1>
      <p class="events_body">
        ينظم فوج جرجيس للكشافة التونسية مجموعة من الفعاليات الثقافية والرياضية
        والترفيهية والتعليمية والتطوعية والتوعوية لتوفير بيئة ملائمة للتعلم
        والتنمية الشخصية للأطفال والشباب
      </p>
      <v-container style="margin-top: 1rem">
        <v-row>
          <v-col>
            <v-card>
              <v-card-title>
                <h3 style="font-size: 1rem">الأنشطة الثقافية والتعليمية</h3>
              </v-card-title>
              <v-carousel :cycle="true" :continuous="true">
                <v-carousel-item v-for="i in [1, 2, 3]" :key="i">
                  <img :src="`/cult${i}.jpg`" width="100%" height="100%" />
                </v-carousel-item>
              </v-carousel>
            </v-card>
          </v-col>
          <v-col>
            <v-card>
              <v-card-title>
                <h3 style="font-size: 1rem">الأنشطة والرياضية والترفيهية</h3>
              </v-card-title>
              <v-carousel :cycle="true" :continuous="true">
                <v-carousel-item v-for="i in [1, 2, 3]" :key="i">
                  <img :src="`/sport${i}.jpg`" width="100%" height="100%" />
                </v-carousel-item>
              </v-carousel>
            </v-card>
          </v-col>
          <v-col>
            <v-card>
              <v-card-title>
                <h3 style="font-size: 1rem">الأنشطة التطوعية والتوعوية</h3>
              </v-card-title>
              <v-carousel :cycle="true" :continuous="true">
                <v-carousel-item v-for="i in [1, 2, 3]" :key="i">
                  <img :src="`/ben${i}.jpg`" width="100%" height="100%" />
                </v-carousel-item>
              </v-carousel>
            </v-card>
          </v-col>
        </v-row>
      </v-container>
      <div class="separator separator-primary"></div>
      <v-container>
        <div class="map-container">
          <h1 class="text-light">موقعنا</h1>
          <iframe
            width="100%"
            height="100%"
            id="gmap_canvas"
            src="https://maps.google.com/maps?q=Le théatre municipal de Zarzis&t=&z=16&ie=UTF8&iwloc=&output=embed"
            frameborder="0"
            scrolling="no"
            marginheight="0"
            marginwidth="0"
          ></iframe>
        </div>
      </v-container>
    </div>
    <!-- <div class="footer">
      <v-container>
        <v-row>
          <v-col>
            <img
              src="/favicon.ico"
              style="border-radius: 100%"
              width="100px"
              height="100px"
            />
            <h1>المسار</h1>
          </v-col>

          <v-col> test </v-col>
        </v-row>
      </v-container>
    </div> -->
    <!-- Remove the container if you want to extend the Footer to full width. -->
    <div class="w-100 my-5">
      <!-- Footer -->
      <footer
        class="text-center text-lg-start text-white"
        style="background-color: #3e4551"
      >
        <!-- Grid container -->
        <div class="container p-4 pb-0">
          <!-- Section: Links -->
          <section class="">
            <!--Grid row-->
            <div class="row">
              <!--Grid column-->
              <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
                <h5 class="text-uppercase">فوج جرجيس</h5>

                <p>
                  فوج جرجيس للكشافة التونسية هو فوج يقع في مدينة جرجيس ويتكون من
                  مجموعة من الفرق الكشفية ويعمل على تنمية الشباب وتوفير بيئة
                  ملائمة للتعلم والتنمية الشخصية للأطفال والشباب
                </p>
              </div>
              <!--Grid column-->
              <div class="col-2"></div>
              <div class="col-2"></div>
              <div class="col-2"></div>
              <!--Grid column-->
              <div class="col">
                <img
                  src="/favicon.ico"
                  width="100px"
                  height="100px"
                  style="border-radius: 100%"
                />
              </div>
              <!--Grid column-->
            </div>
            <!--Grid row-->
          </section>
          <!-- Section: Links -->

          <hr class="mb-4" />

          <!-- Section: CTA -->
          <section class="">
            <p class="d-flex justify-content-center align-items-center">
              <span class="me-3">سجل مجانا</span>
              <router-link
                to="register"
                class="btn btn-outline-light btn-rounded"
              >
                سجل الآن!
              </router-link>
            </p>
          </section>
          <!-- Section: CTA -->

          <hr class="mb-4" />

          <!-- Section: Social media -->
          <section class="mb-4 text-center">
            <!-- Facebook -->
            <a
              class="btn btn-outline-light btn-floating m-1"
              href="https://www.facebook.com/scout1zarzis/"
              role="button"
              ><v-icon>mdi-facebook</v-icon>
            </a>

            <!-- Instagram -->
            <a
              class="btn btn-outline-light btn-floating m-1"
              href="https://www.instagram.com/scouts_zarzis/"
              role="button"
              ><v-icon>mdi-instagram</v-icon>
            </a>
          </section>
          <!-- Section: Social media -->
        </div>
        <!-- Grid container -->

        <!-- Copyright -->
        <div
          class="text-center p-3"
          style="background-color: rgba(0, 0, 0, 0.2)"
        >
          © 2023 Copyright:
          <a class="text-white" href="https://github.com/smurfsDev"
            >SmurfsDev</a
          >
        </div>
        <!-- Copyright -->
      </footer>
      <!-- Footer -->
    </div>
    <!-- End of .container -->
  </div>
</template>

<script>
// @ is an alias to /src

export default {
  name: "Home",
  components: {},
  data: () => ({}),
};
</script>
<style scoped>
#home__image {
  position: relative;
  top: 0;
  left: 0;
}

.home {
  position: relative;
  width: 100%;
  height: 100%;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  text-align: center;
  color: #fff;
}

.home__content {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 90vh;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  text-align: center;
}

.separator {
  width: 100px;
  height: 3px;
  background-color: #fff;
  margin: 10px 0;
}

.separator-primary {
  background-color: #5e72e4;
}

.events__content {
  width: 100%;
  height: 100%;
  padding-top: 100px;
  background-color: rgb(245, 243, 243);
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  text-align: center;
  color: #000;
}

.events_title {
  font-size: 4rem;
  font-weight: 700;
  margin-bottom: 2rem;
}

.events_body {
  font-size: 1.5rem;
  font-weight: 400;
  margin-bottom: 1rem;
  margin-left: 19%;
  margin-right: 19%;
}

.map-container {
  height: 500px;
  padding: 20px;
  background-color: #5e72e4;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  text-align: center;
  color: #000;
}

.map-container iframe {
  height: 100%;
  border: 0;
}

.footer {
  width: 100%;
  height: 100px;
  background-color: #5e72e4;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  text-align: center;
  color: #000;
}
</style>
