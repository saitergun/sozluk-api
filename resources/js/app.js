import 'bootstrap/dist/js/bootstrap'

import Alpine from 'alpinejs'
import alpineFilter from './filter.alpine'

// document.addEventListener('alpine:init', () => {
//   Alpine.data('filter', alpineFilter)
// })

// document.addEventListener('alpine:initialized', () => {
//   console.log('alpine:initialized')
// })

Alpine.data('filter', alpineFilter)
Alpine.start()
