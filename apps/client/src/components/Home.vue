<template>
  <div>
    <h1>Page d'accueil - Commentaires</h1>
    <div v-if="comments.length === 0">
      <h2>Pas de commentaires pour le moment</h2>
    </div>
  </div>
  <div>
    <div v-for="comment in comments" :key="comment.id">
      <h2>{{ comment.author }}</h2>
      <p>{{ comment.content }}</p>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapState } from 'vuex'

export default {
  computed: mapState({
    comments: state => state.comments.articleComments
  })
}

</script>
