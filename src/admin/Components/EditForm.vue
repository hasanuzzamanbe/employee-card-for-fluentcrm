<template>
  <div class="pt-4">
    <h3>Update employee</h3>
    <el-form size="medium" label-position="top">
      <el-row :gutter="20">
        <el-col :span="12">
          <el-form-item label="">
            <el-input
              v-model="employee.name"
              placeholder="Enter your name"
            ></el-input>
          </el-form-item>
        </el-col>
        <el-col :span="12">
          <el-form-item label="">
            <el-input
                v-model="employee.email"
                placeholder="Enter your email"
            ></el-input>
          </el-form-item>
        </el-col>
        <el-col :span="12">
          <el-form-item label="">
            <el-input
                type="textarea"
                v-model="employee.description"
                placeholder="I am working as a web developer till 5 years...."
            ></el-input>
          </el-form-item>
        </el-col>
        <el-col :span="12">
          <el-form-item label="">
            <div class="flex gap-2 items-center">
              <div>
                <MediaButton @onMediaSelected="onMediaSelected" />
              </div>
              <img
                v-if="employee.image"
                :src="employee.image"
                class="w-[50px] aspect-square object-fill rounded-full"
              />
            </div>
          </el-form-item>
        </el-col>
        <el-col :span="12">
          <el-form-item label="">
            <el-input
              v-model="employee.designation"
              placeholder="Designation"
            ></el-input>
          </el-form-item>
        </el-col>
      </el-row>
      <h3 class="mt-4">Address:</h3>
      <el-row :gutter="20">
        <el-col :span="12">
          <el-form-item label="Address line 1">
            <el-input
              v-model="employee.address_1"
              placeholder="Jalalabad R/a"
            ></el-input>
          </el-form-item>
        </el-col>
        <el-col :span="12">
          <el-form-item label="City">
            <el-input v-model="employee.city" placeholder="sylhet"></el-input>
          </el-form-item>
        </el-col>
        <el-col :span="12">
          <el-form-item label="State">
            <el-input v-model="employee.state" placeholder="Sylhet"></el-input>
          </el-form-item>
        </el-col>
        <el-col :span="12">
          <el-form-item label="Postcode">
            <el-input
              v-model="employee.postcode"
              placeholder="12345"
            ></el-input>
          </el-form-item>
        </el-col>
      </el-row>
      <el-row :gutter="20">
        <el-col :span="12">
          <el-form-item label="Phone">
            <el-input
              v-model="employee.phone"
              placeholder="+880 1234567890"
            ></el-input>
          </el-form-item>
        </el-col>
      </el-row>
      <h3 class="mt-4">Socials:</h3>
      <el-row :gutter="20">
        <el-col :span="12">
          <el-form-item label="Facebook">
            <el-input size="small"
              v-model="employee.social_info.facebook"
              placeholder="https://facebook.com/username"
            ></el-input>
          </el-form-item>
        </el-col>
        <el-col :span="12">
          <el-form-item label="Twitter">
            <el-input size="small"
              v-model="employee.social_info.twitter"
              placeholder="https://twitter.com/username"
            ></el-input>
          </el-form-item>
        </el-col>

        <el-col :span="12">
          <el-form-item label="Linkedin">
            <el-input size="small"
              v-model="employee.social_info.linkedin"
              placeholder="https://linkedin.com/username"
            ></el-input>
          </el-form-item>
        </el-col>

        <el-col :span="12">
          <el-form-item label="Instagram">
            <el-input size="small"
              v-model="employee.social_info.instagram"
              placeholder="https://instagram.com/username"
            ></el-input>
          </el-form-item>
        </el-col>
        <el-col :span="12">
        <!-- github -->
          <el-form-item label="Github">
            <el-input size="small"
              v-model="employee.social_info.github"
              placeholder="github url">
            </el-input>
          </el-form-item>
        </el-col>
        <!-- website -->
        <el-col :span="12">
          <el-form-item label="Website">
            <el-input size="small"
              v-model="employee.social_info.website"
              placeholder="website url">
            </el-input>
          </el-form-item>
        </el-col>

        <el-col :span="12">
          <el-form-item label="Wordpress">
            <el-input size="small"
              v-model="employee.social_info.wordpress"
              placeholder="wordpress url">
            </el-input>
          </el-form-item>
        </el-col>
        <!-- dribble -->
        <el-col :span="12">
          <el-form-item label="Dribble">
            <el-input size="small"
              v-model="employee.social_info.dribble"
              placeholder="dribble url">
            </el-input>
          </el-form-item>
        </el-col>
        <!-- figma -->
        <el-col :span="12">
          <el-form-item label="Figma">
            <el-input size="small"
              v-model="employee.social_info.figma"
              placeholder="figma url">
            </el-input>
          </el-form-item>
        </el-col>
      </el-row>
      <el-row>
        <el-button
          size="large"
          class="bg-blue-400"
          type="primary"
          @click="update"
          >Update</el-button
        >
      </el-row>
    </el-form>
  </div>
</template>
<script>
import MediaButton from './MediaButton.vue'
export default {
  name: 'edit-form',
  data () {
    return {
      
    }
  },
  components: {
    MediaButton
  },
  props: {
    employee: {
      type: Object,
      required: true
    }
  },
  methods: {
    update () {
      this.$emit('updateEmployee', this.employee)
    },
    onMediaSelected ($selected) {
      if ($selected.length) {
        console.log($selected)
        this.employee.image = $selected[0].url
      }
    }
  }
}
</script>
