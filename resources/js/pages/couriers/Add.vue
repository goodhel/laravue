<template>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Add New Courier</h3>
            </div>
            <div class="card-body">
                <courier-form ref="formCourier"></courier-form>
                <div class="form-group">
                    <button class="btn btn-primary btn-sm btn-flat" @click.prevent="submit">
                        <i class="fa fa-save"></i> Add New
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import { mapActions, mapState, mapMutations } from 'vuex'
    import FormCourier from './Form.vue'
    export default {
        name: 'AddCourier',
        methods: {
            submit() {
                this.$refs.formCourier.submit()
            }
        },
        components: {
            'courier-form': FormCourier
        }
    }
</script>