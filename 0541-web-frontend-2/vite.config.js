import { fileURLToPath, URL } from 'node:url'

import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [vue()],
  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./src', import.meta.url))
    }
  },
 
      
// betterComments: {
//   // highlightPlainText: true,
//   // sortBy: 'alphabetical',
//   tags: [
//     {
//       tag: '!',
//       color: '#FF2D00',
//       textColor: '#FFFFFF',
//       multiline: true,
//     },
//     {
//       tag: '?',
//       color: '#3498DB',
//       textColor: '#FFFFFF',
//       multiline: true,
//     },
//     {
//       tag: '//',
//       color: '#474747',
//       textColor: '#FFFFFF',
//       multiline: false,
//     },
//   ],
// },
})
