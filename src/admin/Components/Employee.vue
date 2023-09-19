<template>
  <div class="w-[calc(100%+20px)] h-full ml-[-20px] lg:absolute">

    <div class="h-full">

      <div class=" bg-white p-4">
        <a class="cursor-pointer text-lg" @click="$router.go(-1)"> Employees </a><span> / {{ employee?.name }}</span>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-3 xl:grid-cols-4 h-[calc(100%-50px)] gap-4">


        <div class="col-span-full lg:col-span-2 xl:col-span-3 h-full lg:overflow-y-scroll employee-info-wrapper">

          <div class="p-4 lg:pr-0" >
            <div class="employee-card p-8 bg-white rounded" >

              <div v-if="!loading">
                <div class="text-right">
                  <el-button @click="edit" :icon="Edit">Edit Employee</el-button>
                </div>
                <div class="employee-profile grid grid-cols-1 lg:grid-cols-3 gap-8">

                  <div class="col-span-full lg:col-span-1">
                    <div class="lg:pr-4 border-solid border-0 lg:border-r border-gray-200 " >

                      <div >
                        <div v-if="employee.image" class="employee-profile-image">
                          <img class="border rounded-lg w-full aspect-square object-fill" :src="employee.image"
                               alt="Employee Image"/>
                        </div>

                        <h2 class="text-center text-2xl m-0 text-gray-700">{{ employee.name }}</h2>
                        <p class="text-sm">Designation: {{ employee.designation }}</p>
                        <p class="text-sm text-justify">{{ employee.description }}</p>
                      </div>
                    </div>
                  </div>

                  <div class="col-span-full lg:col-span-2">
                    <div class="employee-profile-info">

                      <table>
                        <tbody>
                        <tr>
                          <td class="w-[100px]">Email:</td>
                          <td><a :href="'mail-to:' + employee.email">{{ employee.email }}</a></td>
                        </tr>

                        <tr>
                          <td>Phone:</td>
                          <td><p>{{ employee.phone }}</p></td>
                        </tr>

                        <tr>
                          <td>Address:</td>
                          <td>
                            <table>
                              <tbody>
                              <tr>
                                <td class="w-[100px]">Address Line:</td>
                                <td>{{ employee.address_1 }}</td>
                              </tr>

                              <tr>
                                <td>City:</td>
                                <td>{{ employee.city }}</td>
                              </tr>

                              <tr>
                                <td>State:</td>
                                <td>{{ employee.state }}</td>
                              </tr>

                              <tr>
                                <td>Post Code:</td>
                                <td>{{ employee.postcode }}</td>
                              </tr>
                              </tbody>
                            </table>
                          </td>
                        </tr>

                        </tbody>
                      </table>

                    </div>

                    <div class="employee-other-info">
                      <div v-for="other in employee.other_info">
                        <p>{{ other }}</p>
                      </div>
                    </div>

                    <div class="employee-social-links">
                      <h3>Socials:</h3>
                      <div class="border-2 border-black">
                        <table>
                          <template v-for="(social,link) in employee.social_info">
                            <tr v-if="social">
                              <td>{{ link }}</td>
                              <td><a style="text-decoration: none;" :href="social" target="_blank"
                                     v-html="social"></a>
                              </td>
                            </tr>
                          </template>
                        </table>

                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div v-else class="flex w-full min-h-[300px] justify-center items-center">
                <div role="status">
                  <svg aria-hidden="true" class="w-8 h-8 mr-2 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="gray"/>
                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                  </svg>
                  <span class="sr-only">Loading...</span>
                </div>
              </div>

            </div>

          </div>

        </div>

        <div class="col-span-full lg:col-span-1 h-full">
          <div
              class="employee-qr h-full p-4 ">
            <div class="bg-white rounded shadow-lg p-8 text-center">
              <h3 class="m-0 mb-4">QR Code</h3>
              <div>
                <img class="shadow-lg" :src="'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=' + url"
                     alt="QR Code"/>
              </div>
              <br/>
              Scan this QR code to save this contact card to your phone. or visit this link.
              <br>
              <p class="m-0 mt-4">Preview: <a class="" target="_blank" :href="url">{{ url }}</a></p>
            </div>
          </div>
        </div>
      </div>
    </div>


    <el-dialog
        v-model="addOrEditDialog"
        width="70%"
        align-center
    >
      <edit-form :employee="employee" @updateEmployee="update"></edit-form>
    </el-dialog>
  </div>

</template>
<script>
import EditForm from './EditForm.vue';
import {Edit} from '@element-plus/icons-vue';

export default {
  name: 'employee',
  components: {
    EditForm,
  },
  computed: {
    Edit() {
      return Edit
    },
    url() {
      return window.employeeCard.site_url + '/person/' + this.employee?.hash
    }
  },
  data() {
    return {
      employee: {},
      addOrEditDialog: false,
      loading: true
    }
  },

  methods: {
    edit() {
      this.addOrEditDialog = true;
    },
    getEmployee() {
      this.loading = true;
      this.$adminGet({
        id: this.$route.params.id,
        route: 'get_employee'
      }).then(response => {
        this.employee = response.data.data
        setTimeout(()=>{
          this.loading = false;
        },1000)
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
