<template>
    <div class="col-sm-6 col-md-4 mb-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{post.title}}</h5>
                <h6 class="card-subtitle mb-2 text-muted">By {{post.user.name}}</h6>
                <p class="card-text truncate">
                    {{post.body}}
                </p>
                <p class="card-text text-right"><small class="text-muted">{{post.created_at}}</small></p>
                <a :href="`/posts/${post.id}`" class="btn btn-primary btn-sm">Read more</a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "PostComponent",
        props:['post']
    }
</script>

<style scoped>
    .truncate {
        display: block;
        display: -webkit-box;
        -webkit-line-clamp: 4;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
