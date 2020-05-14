<template>
    <div class="card">
        <div class="card-header">
            {{tag ? `Showing Post for ${tag.name} tag`:'Posts'}}
            <a v-if="tag" href="/posts" class="btn btn-primary float-right">Show All</a>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-4">
                    <input type="text" class="form-control" placeholder="Search" v-model="searchQuery">
                </div>
            </div>
            <div v-if="isLoading" class="d-flex justify-content-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <template v-if="!isLoading">
                <p v-if="posts.length === 0" class="text-center">No, record found.</p>
                <div class="row">
                    <Post v-if="posts.length > 0"
                          v-for="(post,index) in posts" :key="post.id"
                          :post="post"/>
                </div>
                <Pagination :align="'right'" :showDisabled="true" :data="paginationData"
                            @pagination-change-page="getPosts"/>
            </template>
        </div>
    </div>
</template>

<script>
    import postMixins from "../../Mixins/postMixins";

    export default {
        name: "Posts",
        props: ['tag'],
        mixins: [postMixins],
        components: {
            Post: () => import('./PostComponent'),
        },
        methods: {
            getUrl(page) {
                let url = `/posts?page=${page}`
                url = this.searchQuery ? url + `&search=${this.searchQuery}` : url
                return this.tag ? url + `&tagId=${this.tag.id}` : url
            }
        }
    }
</script>

<style scoped>

</style>
