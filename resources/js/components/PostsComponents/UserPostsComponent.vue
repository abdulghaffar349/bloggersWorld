<template>
    <div class="card">
        <div class="card-header">
            Posts
            <a href="/posts/create" class="btn btn-primary float-right">Add Post</a>
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
                <div class="table-responsive">
                    <table id="posts-table" class="table table-hover">
                        <thead>
                        <tr>
                            <th>Title</th>
                            <th style="width: 30%"> Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-if="posts.length > 0" v-for="(post,index) in posts" :key="post.id">
                            <td>{{post.title}}</td>
                            <td>
                                <a :href="`/posts/${post.id}`" class="badge badge-primary">View</a>
                                <a :href="`/posts/${post.id}/edit`" class="badge badge-success">Edit</a>
                                <a href="javascript:void(0)" @click="confirmation(post.id)" class="badge badge-danger">Delete</a>
                            </td>
                        </tr>
                        <tr v-if="posts.length === 0">
                            <td colspan="3" class="text-center">No, record found.</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <Pagination :align="'right'" :showDisabled="true" :data="paginationData"
                            @pagination-change-page="getPosts"/>
            </template>
        </div>
    </div>
</template>

<script>
    import postMixins from '../../Mixins/postMixins'

    export default {
        name: "UserPostsComponent",
        mixins: [postMixins],
        data() {
            return {
                apiRequests: []
            }
        },
        methods: {
            confirmation(id) {
                let self = this
                swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        self.deletePost(id)
                    }
                });
            },
            getUrl(page) {
                let url = `/user/posts?page=${page}`
                return this.searchQuery ? url + `&search=${this.searchQuery}` : url
            },

            async deletePost(id) {
                try {
                    const url = `/posts/${id}`
                    if (!this.apiRequests.includes(url)) {
                        this.apiRequests.push(url)
                        const response = await axios.delete(url);
                        swal("Post has been deleted!", {
                            icon: "success",
                        });
                        this.removePost(id)
                        this.clearApiRequest(response.config.url)
                    }
                } catch (error) {
                    this.clearApiRequest(error.response.config.url)
                }
            },

            removePost(id) {
                const posts = [...this.posts];
                const index = this.posts.findIndex(post => post.id = id);
                posts.splice(index, 1)
                this.posts = posts
            },

            clearApiRequest(url) {
                const apiRequest = [...this.apiRequests];
                const index = apiRequest.indexOf(url);
                apiRequest.splice(index, 1)
                this.apiRequests = apiRequest
            }
        }
    }
</script>

<style scoped>

</style>
