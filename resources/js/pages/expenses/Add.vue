<template>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Add New Expenses</h3>
            </div>
            <div class="card-body">
              	<!-- TAMBAHKAN REF PADA CUSTOM TAG INI -->
                <expenses-form ref="formExpense"></expenses-form>
              
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
    import FormExpenses from './Form.vue'
    export default {
        name: 'AddExpenses',
        methods: {
            //KETIKA TOMBOL ADD NEW DITEKAN MAKA FUNGSI INI AKAN DIJALANKAN
            submit() {
                //FUNGSI INI AKAN MEMICU METHOD YANG BERADA DIDALAM FILE FORM.VUE
                //DENGAN MEMANFAATKAN $refs MAKAN KITA DAPAT MENGAKSES PROPERTY YANG ADA DI FILE LAINNYA
                this.$refs.formExpense.submit()
            }
        },
        components: {
            'expenses-form': FormExpenses
        }
    }
</script>