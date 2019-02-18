<template>
  <div class="album py-5 bg-light">
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <img class="card-img-top" alt="Thumbnail [100%x225]" :src="'/images/'+film.film_photo">
        </div>
        <div class="col-md-8">
          <div class="row">
            <div class="col-md-12">
              <h2>{{film.name}}</h2>
              <div v-if="rating">
                <star-rate
                  :value="film.rating"
                  :disabled="true"
                  active-color="#66CC33"
                  type="heart"
                />
              </div>
              <hr>
              <div class="row">
                <div class="col-md-3">
                  <span class="meta-title">Release Date:</span>
                  <span class="meta-text">{{film.release_date}}</span>
                </div>
                <div class="col-md-3">
                  <span class="meta-title">Country:</span>
                  <span class="meta-text">{{film.country}}</span>
                </div>
                <div class="col-md-3">
                  <span class="meta-title">Genre:</span>
                  <span class="meta-text">{{film.genre}}</span>
                </div>
                <div class="col-md-3">
                  <span class="meta-title">Ticket Price:</span>
                  <span class="meta-text">${{film.ticket_price}}</span>
                </div>
              </div>
              <hr>
              <p>{{film.description}}</p>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <h2>Comments</h2>
          <hr>
          <div class="card" v-for="comment in film.comments" :key="comment.id">
            <div class="card-header">
              <span class="commenter-name">{{comment.user.name}}</span>
              <span>made a comment</span>
              <span class="float-right moment-ago">{{ comment.updated_at | moment("from", "now") }}</span>
            </div>
            <div class="card-body">
              <p class="card-text">{{comment.comment}}</p>
            </div>
          </div>
        </div>
      </div>

      <div class="row" v-if="authenticated && user">
        <div class="col-md-12">
          <h2>New Comment</h2>
          <form @submit.prevent="addComment">
            <div class="form-group">
              <label for="Name"></label>
              <input
                type="text"
                class="form-control"
                placeholder="Your Name"
                :value="user.name"
                required
                disabled
              >
            </div>
            <div class="form-group">
              <label for="Comment">Comment</label>
              <textarea
                class="form-control"
                :class="errors.comment ? 'is-invalid' : '' "
                placeholder="Comment"
                v-model="newComment"
                @keydown="errors.comment = ''"
                required
                rows="6"
              ></textarea>
              <div class="invalid-feedback" v-if="errors.comment">{{errors.comment[0]}}</div>
            </div>
            <button class="btn btn-danger float-right">Comment</button>
          </form>
        </div>
      </div>
      <div class="row" v-else>
        <div class="col-md-12">
          <router-link to="/login" tag="button" class="btn btn-danger">Login to comment</router-link>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import StarRate from "vue-cute-rate";

export default {
  data() {
    return {
      authenticated: auth.check(),
      user: auth.user,
      film: [],
      rating: false,
      newComment: "",
      errors: []
    };
  },
  created() {
    let slug = this.$route.params.slug;
    this.fetchFilm(slug);
  },
  methods: {
    fetchFilm(slug) {
      api.call("get", "/api/film/" + slug).then(res => {
        //console.log(res);
        this.film = res.data.data;
        this.rating = true;
      });
    },
    addComment() {
      let commentModel = {
        film_id: this.film.id,
        owner_id: this.user.id,
        comment: this.newComment
      };
      api
        .call("post", "/api/comment", commentModel)
        .then(res => {
          this.newComment = "";
          this.fetchFilm(this.film.slug);
          alert(res.data.success);
        })
        .catch(err => {
          console.log(err);
          this.errors = err.data.errors;
          //alert("Something went wrong. Try again");
        });
    }
  },
  watch: {
    rating: function() {
      return this.rating;
    }
  },
  components: {
    StarRate
  }
};
</script>

<style scoped>
.card {
  margin-bottom: 22px;
  box-shadow: rgba(0, 0, 0, 0.3) 1px 1px 20px;
}
.commenter-name {
  font-weight: bold;
}
span.moment-ago {
  font-style: italic;
}
</style>