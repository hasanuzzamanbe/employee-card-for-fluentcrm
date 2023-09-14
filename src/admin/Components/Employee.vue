<template>
        <div>
                <div class="flex flex-wrap items-center">
                        <a class="cursor-pointer text-lg" @click="$router.go(-1)"> Employees </a><span> / {{ employee?.name }}</span>
                </div>

             <div class="employee-profile-section flex shadow-sm">
                <div class="employee-card w-[70%] p-8">
                        <el-button @click="edit" :icon="Edit" class="float-right">Edit Employee</el-button>

                        <div class="employee-profile">
                                <div v-if="employee.image" class="employee-profile-image">
                                        <img width="300" class="border rounded-lg" :src="employee.image" alt="Employee Image" />
                                </div>
                                <div class="employee-profile-info">
                                        <h2>{{ employee.name }}</h2>
                                        <h3 class="text-sm">{{ employee.designation }}</h3>
                                        <a :href="'mail-to:' + employee.email">{{ employee.email }}</a>
                                        Phone: <p>{{ employee.phone }}</p>
                                        <h3 class="m-0">Address:</h3>
                                        <br />
                                        <span>{{ employee.address_1 }}</span>,
                                        <span>{{ employee.city }}</span>, <br />
                                        <span>{{ employee.state }}</span>,
                                        <span>{{ employee.postcode }}</span>,
                                </div>

                                <div class="employee-other-info">
                                        <div v-for="other in employee.other_info">
                                                <p>{{ other }}</p>
                                        </div>
                                </div>

                                <div class="employee-social-links">
                                        <h3>Socials:</h3>
                                        <div class="border-2 border-black" >
                                                <p v-for="(social,link) in employee.social_info">
                                                        <span>{{link}}:</span>
                                                        <a style="text-decoration: none;" :href="social" target="_blank">{{social}}</a>
                                                </p>
                                        </div>
                                </div>

                        </div>
                
                        

                </div>
                <div class="employee-qr w-[30%] p-8 shadow-lg h-[100vh]">
                        <h3>QR Code</h3>
                        <div>
                                <img :src="'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=' + url" alt="QR Code" />
                        </div>
                        <br/>
                        Scan this QR code to save this contact card to your phone. or visit this link.
                        <br>
                        <h3>Preview:</h3><br/>
                        <a class="text-lg" target="_blank" :href="url">{{url}}</a>
                </div>

                <el-dialog
                        v-model="addOrEditDialog"
                        title="Update Employee Info"
                        width="70%"
                        align-center
                >
                        <edit-form :employee="employee" @updateEmployee="update"></edit-form>
                </el-dialog>
                </div>     
        </div>

</template>
<script>
import EditForm from './EditForm.vue';
import { Edit } from '@element-plus/icons-vue';
export default {
  name: 'employee',
  components: {
    EditForm,
  },
  computed:{
        Edit() {
                return Edit
        }
  },
  data () {
    return {
        employee: {},
        addOrEditDialog: false,
        url: window.employeeCard.site_url + '/contact_card/' + this.$route.params.id
    }
  },
  methods: {
        edit() {
             this.addOrEditDialog = true;
        },
        getEmployee() {
                this.$adminGet({
                        id: this.$route.params.id,
                        route: 'get_employee'
                }).then(response => {
                        this.employee = response.data.data
                })
        },
        update(employeeInfo) {
                this.addOrEditDialog = false
                this.$adminPost({
                        route: 'update_employee',
                        data: employeeInfo
                }).then(response => {
                        this.getEmployee()
                })
        },
  },
  mounted() {
        this.getEmployee();
  }
}
</script>
