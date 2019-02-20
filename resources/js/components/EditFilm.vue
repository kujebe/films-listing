<template>
  <div class="album py-5 bg-light">
    <div class="container">
      <div class="row">
        <div class="col-md-8 offset-md-2">
          <h3>Edit Film</h3>
          <hr>
          <form @submit.prevent="saveFilm">
            <div class="form-group">
              <label for="Film Name">Film Name</label>
              <input
                type="text"
                class="form-control"
                :class="errors.name ? 'is-invalid' : '' "
                placeholder="Film Name"
                v-model="film.name"
              >
              <div class="invalid-feedback" v-if="errors.name">{{errors.name[0]}}</div>
            </div>

            <div class="form-group">
              <label for="Slug">Film Slug</label>
              <input
                type="text"
                class="form-control"
                :class="errors.slug ? 'is-invalid' : '' "
                placeholder="Slug"
                v-model="film.slug"
                disabled
              >
              <div class="invalid-feedback" v-if="errors.slug">{{errors.slug[0]}}</div>
            </div>

            <div class="form-group">
              <label for="Film Description">Film Description</label>
              <textarea
                type="text"
                class="form-control"
                :class="errors.description ? 'is-invalid' : '' "
                placeholder="Film Name"
                v-model="film.description"
                rows="6"
              ></textarea>
              <div class="invalid-feedback" v-if="errors.description">{{errors.description[0]}}</div>
            </div>

            <div class="form-group">
              <label for="Genre">Genre</label>
              <input
                type="text"
                class="form-control"
                :class="errors.genre ? 'is-invalid' : '' "
                placeholder="Genre"
                v-model="film.genre"
              >
              <div class="invalid-feedback" v-if="errors.genre">{{errors.genre[0]}}</div>
            </div>

            <div class="form-group">
              <label for="Release Date">Release Date</label>
              <input
                type="text"
                class="form-control"
                :class="errors.release_date ? 'is-invalid' : '' "
                placeholder="Release Date"
                v-model="film.release_date"
              >
              <div class="invalid-feedback" v-if="errors.release_date">{{errors.release_date[0]}}</div>
            </div>

            <div class="form-group">
              <label for="Ticket Price">Ticket Price</label>
              <input
                type="text"
                class="form-control"
                :class="errors.ticket_price ? 'is-invalid' : '' "
                placeholder="Release Date"
                v-model="film.ticket_price"
                @keydown="errors.ticket_price = ''"
              >
              <div class="invalid-feedback" v-if="errors.ticket_price">{{errors.ticket_price[0]}}</div>
            </div>

            <div class="form-group">
              <label for="Film Rating">Film Rating</label>
              <select
                class="form-control"
                :class="errors.rating ? 'is-invalid' : '' "
                name="rating"
                v-model="film.rating"
              >
                <option value="film.rating" selected v-if="film.rating">{{film.rating}}</option>
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
              </select>
              <div class="invalid-feedback" v-if="errors.rating">{{errors.rating[0]}}</div>
            </div>

            <div class="form-group">
              <label for="Country">Country</label>
              <input
                type="text"
                class="form-control"
                :class="errors.country ? 'is-invalid' : '' "
                placeholder="Country"
                v-model="film.country"
              >
              <div class="invalid-feedback" v-if="errors.country">{{errors.country[0]}}</div>
            </div>
            <div class="form-group">
              <label for>Film Photo</label>
              <input type="file" v-on:change="onImageChange" class="form-control">
              <div
                :class="errors.film_photo ? 'is-invalid' : '' "
                v-if="errors.film_photo"
              >{{errors.film_photo[0]}}</div>
            </div>
            <button class="btn btn-danger float-right">Save</button>
          </form>
          <div>
            <img v-if="temp_photo" :src="temp_photo" class="img-responsive film-image">
            <img v-else :src="'/images/'+film.film_photo" class="img-responsive film-image">
          </div>
          <div class="alert alert-success" v-if="status === 200">Film updated successfully</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      film: [],
      temp_photo: "",
      errors: [],
      status: ""
    };
  },
  created() {
    let slug = this.$route.params.slug;
    this.fetchFilm(slug);
  },
  methods: {
    fetchFilm(slug) {
      api
        .call("get", process.env.MIX_APP_URL + "api/film/" + slug)
        .then(res => {
          //console.log(res);
          this.film = res.data.data;
        });
    },
    onImageChange(e) {
      let files = e.target.files || e.dataTransfer.files;
      if (!files.length) {
        return;
      }
      this.createImage(files[0]);
    },
    createImage(file) {
      let reader = new FileReader();
      reader.onload = e => {
        this.temp_photo = e.target.result;
      };
      reader.readAsDataURL(file);
    },
    saveFilm() {
      console.log(this.film);
      api
        .call(
          "put",
          process.env.MIX_APP_URL + "api/film/" + this.film.id,
          this.film,
          {
            headers: {
              "Content-Type": "application/x-www-form-urlencoded"
            }
          }
        )
        .then(res => {
          //console.log(res);
          this.status = res.status;
          console.log(this.status);
        })
        .catch(err => {
          console.log(err);
          this.errors = err.data.errors;
        });
    }
  },
  watch: {
    temp_photo: function() {
      this.film.film_photo = this.temp_photo;
      //return "/images/" + temp_photo;
    }
  }
};
</script>