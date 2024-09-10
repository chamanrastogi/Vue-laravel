<script setup>

import DefaultLayout from '../components/layouts/DefaultLayout.vue'
</script>

<template>
  <DefaultLayout>
    <CAlert :visible="message" :color="color" dismissible @close="!message">{{ message }}</CAlert>
    <CButton color="success" @click="addPost()">Add Post</CButton>
    <CTable striped>
      <CTableHead>
        <CTableRow>
          <CTableHeaderCell scope="col">Id</CTableHeaderCell>
          <CTableHeaderCell scope="col">User Id</CTableHeaderCell>
          <CTableHeaderCell scope="col">Title</CTableHeaderCell>
          <CTableHeaderCell scope="col">Action</CTableHeaderCell>
        </CTableRow>
      </CTableHead>
      <CTableBody>
        <CTableRow v-if="(items.length) !== 0" id="post-{{ item.id }}" v-for="item in items" :key="item.id">
          <CTableHeaderCell scope="row">{{ item.id }}</CTableHeaderCell>
          <CTableDataCell>{{ item.userId }}</CTableDataCell>
          <CTableDataCell>{{ item.title }}</CTableDataCell>
          <CTableDataCell>
            <div class="d-grid gap-2 d-md-flex">
              <CButton color="warning" @click="getPost(item.id)">View</CButton>
              <CButton color="info" @click="editPost(item.id)">Edit</CButton>
              <CButton color="danger" @click="deletePost(item.id)">Delete</CButton>
            </div>

          </CTableDataCell>
        </CTableRow>
        <CTableRow v-if="(items.length) === 0">
          <CTableHeaderCell colspan="4" scope="row" class="text-center text-danger"> No Data Found</CTableHeaderCell>

        </CTableRow>
      </CTableBody>
    </CTable>
    <CModal backdrop="static" :visible="visibleStaticBackdropDemo" @close="() => { visibleStaticBackdropDemo = false }">
      <CModalHeader>
        <CModalTitle>{{ post.title }}</CModalTitle>
      </CModalHeader>
      <CModalBody>{{ post.body }}</CModalBody>
      <CModalFooter>
        <CButton color="secondary" @click="() => { visibleStaticBackdropDemo = false }">
          Close
        </CButton>
        <CButton color="primary">Save changes</CButton>
      </CModalFooter>
    </CModal>

    <CModal backdrop="static" :visible="visibleStaticBackdropEdit" @close="() => { visibleStaticBackdropEdit = false }">
      <CModalHeader>
        <CModalTitle>Edit {{ newPost.title }}</CModalTitle>
      </CModalHeader>
      <CForm @submit.prevent="submitFormUpdate">
        <CModalBody>
          <div v-if="errors.length" class="error-message">
            <ul>
              <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
            </ul>
          </div>
          <div class="mb-3">

            <CFormSelect v-model="newPost.userid">
              <option>Select One User</option>
              <option v-for="number in numbers" :selected="uid === number" :key="number" :value="number">{{ number }}
              </option>
            </CFormSelect>
          </div>
          <div class="mb-3">
            <CFormLabel for="exampleFormControlInput1">Title</CFormLabel>
            <CFormInput v-model="newPost.title" type="text" placeholder="Title" />
          </div>
          <div class="mb-3">
            <CFormLabel for="exampleFormControlTextarea1">Body</CFormLabel>
            <CFormTextarea v-model="newPost.body" id="exampleFormControlTextarea1" rows="3"></CFormTextarea>
          </div>

        </CModalBody>
        <CModalFooter>
          <CButton color="secondary" @click="() => { visibleStaticBackdropAdd = false }">
            Close
          </CButton>
          <CButton type="submit" color="primary">Save changes</CButton>
        </CModalFooter>
      </CForm>
    </CModal>


    <CModal backdrop="static" :visible="visibleStaticBackdropAdd" @close="() => { visibleStaticBackdropAdd = false }">
      <CModalHeader>
        <CModalTitle>Add Post</CModalTitle>
      </CModalHeader>
      <CForm @submit.prevent="submitForm">
        <CModalBody>
          <div v-if="errors.length" class="error-message">
            <ul>
              <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
            </ul>
          </div>
          <div class="mb-3">
            <CFormSelect v-model="newPost.userid">
              <option>Select One User</option>
              <option v-for="number in numbers" :key="number" :value="number">{{ number }}</option>
            </CFormSelect>
          </div>
          <div class="mb-3">
            <CFormLabel for="exampleFormControlInput1">Title</CFormLabel>
            <CFormInput v-model="newPost.title" type="text" placeholder="Title" />
          </div>
          <div class="mb-3">
            <CFormLabel for="exampleFormControlTextarea1">Body</CFormLabel>
            <CFormTextarea v-model="newPost.body" id="exampleFormControlTextarea1" rows="3"></CFormTextarea>
          </div>

        </CModalBody>
        <CModalFooter>
          <CButton color="secondary" @click="() => { visibleStaticBackdropAdd = false }">
            Close
          </CButton>
          <CButton type="submit" color="primary">Save changes</CButton>
        </CModalFooter>
      </CForm>
    </CModal>
  </DefaultLayout>
</template>

<script>
import axios from 'axios';

import { CTable, CTableRow, CTableHead, CTableHeaderCell, CTableBody, CTableDataCell, CButton } from '@coreui/bootstrap-vue';

import { CModal, CModalHeader, CModalTitle, CModalBody, CModalFooter } from '@coreui/bootstrap-vue';

import {CAlert, CForm, CFormLabel, CFormInput, CFormTextarea, CFormSelect } from '@coreui/bootstrap-vue';
export default {
  components: {

  },
  data() {
    return {
      id: 1,
      uid: '',
      numbers: null,
      visibleStaticBackdropDemo: false,
      visibleStaticBackdropEdit: false,
      visibleStaticBackdropAdd: false,
      items: [],
      color:null,
      message:false,
      post: [],
      newPost: {
        userid: '',
        title: '',
        body: ''
      }, errors: [],
    };
  },
  methods: {
    async loadData() {
      try {
        const response = await axios.get('http://tempo.test/api/posts');
        this.items = response.data;
      } catch (err) {
        this.error = 'Error fetching data: ' + err.message;
        console.error(err);
      }
    },
    async userId() {
      try {
        const response = await axios.get('http://tempo.test/api/userids');
        this.numbers = response.data;
      } catch (err) {
        this.error = 'Error fetching data: ' + err.message;
        console.error(err);
      }
    },
    addPost() {
      this.visibleStaticBackdropAdd = !this.visibleStaticBackdropAdd;

    }, validateForm() {
      this.errors = [];
      if (!this.newPost.title) {
        this.errors.push('Title is required.');
      }
      if (!this.newPost.body) {
        this.errors.push('Body is required.');
      }
      return this.errors.length === 0;
    },

    async submitForm() {
      this.message=false;
      if (this.validateForm()) {
        console.log('Form data before submission:', this.newPost);
        try {
          const response = await axios.post('http://tempo.test/api/posts', this.newPost);
          // console.log('Form data after submission:', response.data);
          // Emit the successful form submission
          this.$emit('submit', response.data);
          this.newPost.userid = '';
          this.newPost.title = '';
          this.newPost.body = '';
          this.color=(response.data.success==true) ?'success' : 'danger';
          this.message=response.data.message;
          this.visibleStaticBackdropAdd = !this.visibleStaticBackdropAdd;
          this.loadData();
        } catch (error) {
          console.error('Error submitting form:', error);
        }
      } else {
        console.log('Validation errors:', this.errors);
      }
    },

    editPost(id) {
      this.id = id;
      axios
        .get('http://tempo.test/api/posts/' + this.id)
        .then(response => {
          this.newPost.title = response.data.title;
          this.newPost.body = response.data.body;
          this.uid = response.data.userId;
          this.newPost.userid = response.data.userId;
          //console.log(response);
          
        })
        .catch(error => {
          console.error('Error fetching data:', error);
        });
      this.visibleStaticBackdropEdit = !this.visibleStaticBackdropEdit;
    }, async submitFormUpdate() {
      this.message=false;
      if (this.validateForm()) {
        console.log('Form data before submission:', this.newPost);
        try {
          const response = await axios.patch('http://tempo.test/api/posts/'+ this.id, this.newPost);
          
          // Emit the successful form submission
          this.$emit('submit', response.data);
          this.color=(response.data.success==true) ?'success' : 'danger';
          this.message=response.data.message;
          // console.log('Form data after submission:', response.data);
          this.visibleStaticBackdropEdit = !this.visibleStaticBackdropEdit;
          this.loadData();
        } catch (error) {
          console.error('Error submitting form:', error);
        }
      } else {
        console.log('Validation errors:', this.errors);
      }
    },
    deletePost(id) {
      this.message=false;
      console.log(id)
      this.id = id;
      axios
        .delete('http://tempo.test/api/posts/' + this.id)
        .then(response => {
          this.color=(response.data.success==true) ?'success' : 'danger';
          this.message=response.data.message;
          this.loadData();
          console.log(response);
        })
        .catch(error => {
          console.error('Error fetching data:', error);
        });
    },
    getPost(id) {
      this.visibleStaticBackdropDemo = !this.visibleStaticBackdropDemo;
      this.id = id;
      axios
        .get('http://tempo.test/api/posts/' + this.id)
        .then(response => {
          this.post = response.data;
          // console.log(this.post);
        })
        .catch(error => {
          console.error('Error fetching data:', error);
        });
    }
  },
  mounted() {
    this.loadData();
    this.userId();
  }
};
</script>
