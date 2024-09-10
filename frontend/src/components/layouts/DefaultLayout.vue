<template> 
<HeaderView/>
<div class="container pt-5">           
      <slot></slot>    
    </div>
  <FooterView/>
</template>

<script>

import HeaderView from '@/components/HeaderView.vue'
import FooterView from '@/components/FooterView.vue'
export default {
  name: 'DefaultLayout',
  components: {
    HeaderView,
    FooterView
  }
}
</script>
