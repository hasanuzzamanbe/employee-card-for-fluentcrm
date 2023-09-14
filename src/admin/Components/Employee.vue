<template>
  <div class="employee-profile-section flex">
        <div class="employee-card w-[70%]">
                {{ employee  }}
        </div>
        <div class="employee-qr w-[30%]">
                <h3>QR Code</h3>
                <div>
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=Example" alt="QR Code" />
                </div>
        </div>
  </div>
</template>
<script>
export default {
  name: 'employee',
  data () {
    return {
        employee: []
    }
  },
  methods: {
    getEmployee () {
      this.$adminGet({
        id: this.$route.params.id,
        route: 'get_employee'
      }).then(response => {
        this.employee = response.data.data
      })
    }
  },
  mounted() {
        this.getEmployee();
  }
}
</script>
