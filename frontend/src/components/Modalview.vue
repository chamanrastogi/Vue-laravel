<template>
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
</template>

<script>
import { CModal, CModalHeader, CModalTitle, CModalBody,CModalFooter } from '@coreui/bootstrap-vue';
</script>

