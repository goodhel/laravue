<template>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Edit Expenses</h3>
            </div>
            <div class="card-body">
                <expenses-form ref="formExpense"></expenses-form>
                <div class="form-group">
                    <button class="btn btn-primary btn-sm btn-flat" @click.prevent="submit">
                        <i class="fa fa-save"></i> Update
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import FormExpenses from './Form.vue'
    export default {
        name: 'EditExpenses',
        methods: {
            submit() {
                this.$refs.formExpense.submit()
            }
        },
        components: {
            'expenses-form': FormExpenses
        }
    }
</script>