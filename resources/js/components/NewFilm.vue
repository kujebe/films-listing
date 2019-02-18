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
                @blur="slugify"
                @keydown="errors.name = ''"
                required
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
                @keydown="errors.slug = ''"
                disabled
                required
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
                @keydown="errors.description = ''"
                rows="6"
                required
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
                @keydown="errors.genre = ''"
                required
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
                @keydown="errors.release_date = ''"
                required
              >
              <div class="invalid-feedback" v-if="errors.release_date">{{errors.release_date[0]}}</div>
            </div>

            <div class="form-group">
              <label for="Ticket Price">Ticket Price</label>
              <input
                type="text"
                class="form-control"
                :class="errors.ticket_price ? 'is-invalid' : '' "
                placeholder="Ticket Price"
                v-model="film.ticket_price"
                @keydown="errors.ticket_price = ''"
                required
              >
              <div class="invalid-feedback" v-if="errors.ticket_price">{{errors.ticket_price[0]}}</div>
            </div>

            <div class="form-group">
              <label for="Film Rating">Film Rating</label>
              <select
                class="form-control"
                :class="errors.rating ? 'is-invalid' : '' "
                v-model="film.rating"
                @keydown="errors.rating = ''"
                required
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
                @keydown="errors.country = ''"
                required
              >
              <div class="invalid-feedback" v-if="errors.country">{{errors.country[0]}}</div>
            </div>
            <div class="form-group">
              <label for>Film Photo</label>
              <input type="file" v-on:change="onImageChange" class="form-control">
              <div
                :class="errors.country ? 'is-invalid' : '' "
                v-if="errors.film_photo"
              >{{errors.film_photo[0]}}</div>
            </div>
            <div>
              <img :src="film.film_photo" v-if="film.film_photo" class="img-responsive film-image">
            </div>
            <hr>
            <div class="alert alert-success" v-if="status === 200">Film updated successfully</div>
            <div class="alert alert-danger" v-if="status === 409">{{errors}}</div>
            <button class="btn btn-danger float-right">Save</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      film: {
        name: "",
        description: "",
        slug: "",
        release_date: "",
        rating: "",
        ticket_price: "",
        country: "",
        genre: "",
        film_photo: ""
      },
      errors: [],
      status: ""
    };
  },
  methods: {
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
        this.film.film_photo = e.target.result;
      };
      reader.readAsDataURL(file);
    },
    saveFilm() {
      console.log(this.film);
      this.status = "";
      this.errors = "";
      api
        .call("post", "/api/film", this.film, {
          headers: {
            "Content-Type": "application/x-www-form-urlencoded"
          }
        })
        .then(res => {
          //console.log(res);
          this.status = res.status;
          this.film.name = "";
          this.film.description = "";
          this.film.slug = "";
          this.film.release_date = "";
          this.film.rating = "";
          this.film.ticket_price = "";
          this.film.country = "";
          this.film.genre = "";
          this.film.film_photo = "";
        })
        .catch(err => {
          this.errors = err.data.errors;
          this.status = err.status;
        });
    },
    slugify() {
      if (this.film.name != "") {
        api
          .call("get", "/api/slugify/" + this.film.name)
          .then(res => {
            this.film.slug = res.data;
          })
          .catch(err => {
            this.errors = err.data.errors;
          });
      }
    }
  }
};
</script>

<style>
.film-image {
  width: 40%;
}
</style>
