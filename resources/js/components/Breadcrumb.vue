<template>
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><router-link :to="{ name: 'home' }"><i class="fa fa-dashboard"></i> Home</router-link>
        <li class="breadcrumb-item active">{{ $route.meta.title }}</li>
    </ol>
</template>

<script>
export default {
    
}
</script>