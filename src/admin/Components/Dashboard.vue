<template>
  <div class="p-4 pr-8">
    <div class="flex items-center justify-between">
      <h1>Employees</h1>
      <el-button class="" @click="addOrEdit">Add employee info</el-button>
    </div>
    <div>
      <div v-if="employees.length !== 0"
        class="employee-card-container grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4"
      >
        <div
          class="employee-card-wrapper rounded-lg shadow-md p-4 bg-white border-solid border border-gray-300"
          v-for="emp in employees"
        >
          <div class="flex gap-4">
            <img
              v-if="emp.image"
              :src="emp.image"
              class="w-[50px] aspect-square object-fill rounded-full"
            />
            <h3>{{ emp.name }}</h3>
          </div>
          <p>{{ emp.email }}</p>
          <p>{{ emp.designation }}</p>
          <el-button-group class="mt-2">
            <!-- <el-button size="small" @click="edit(emp)">Edit</el-button> -->
            <el-button size="small" @click="() => $router.push({name: 'employee', params: {id: emp.id}})">Edit</el-button>
          </el-button-group>

          <el-popconfirm title="Are you sure to delete this?" @confirm="deleteEmployee(emp.id)">
            <template #reference>
                <span class="float-right text-red-500 mt-2 cursor-pointer"><Delete  class="w-4"/></span>
            </template>
          </el-popconfirm>
        </div>
      </div>
      <div v-else>
        <p class="text-center">No employee found! Please add some.</p>
      </div>

      <el-dialog
        v-model="addOrEditDialog"
        title="Add Employee Info"
        width="70%"
        align-center
      >
        <edit-form :employee="employee" @updateEmployee="update"></edit-form>
      </el-dialog>
    </div>
  </div>
</template>
<script>
import EditForm from './EditForm.vue'
import { Delete } from '@element-plus/icons-vue'
export default {
  name: 'dashboard',
  components: {
    EditForm,
    Delete
  },
  data () {
    return {
      addOrEditDialog: false,
      employees: [],
      employee: {
        id: 0,
        name: '',
        email: '',
        designation: '',
        address_1: '',
        city: '',
        state: '',
        phone: '',
        postcode: '',
        other_info: '',
        image: '',
        social_info: {
          facebook: '',
          twitter: '',
          linkedin: '',
          instagram: '',
          github: '',
          figma: '',
          wordpress: '',
          dribble: '',
          website: '',
        },
        status: 1
      },
      employeeMock: {}
    }
  },
  methods: {
    view () {},
    deleteEmployee(id) {
        this.$adminPost({
                route: 'delete_employee',
                id: id
            }).then(response => {
                this.getEmployees()
            })
    },
    getEmployees () {
      this.$adminGet({
        route: 'get_employees'
      }).then(response => {
        this.employees = response.data.data
      })
    },
    addOrEdit (emp) {
      this.employee = JSON.parse(JSON.stringify(this.employeeMock))
      this.addOrEditDialog = true
    },
    edit (emp) {
      this.employeeMock = this.employee
      this.employee = emp
      this.addOrEditDialog = true
    },
    update () {
      this.addOrEditDialog = false
      this.$adminPost({
        route: 'update_employee',
        data: this.employee
      }).then(response => {
        this.getEmployees()
      })
    },
    addSocial () {
      this.employee.social_info.push({
        name: '',
        link: '',
        icon: ''
      })
    }
  },
  mounted () {
    this.getEmployees()
    this.employeeMock = { ...this.employee }
  }
}
</script>
