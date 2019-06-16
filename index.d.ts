import '@nuxtjs/axios'
import 'buefy/types'
import 'vee-validate/types'

import Vue, { ComponentOptions } from 'vue'
import { CookieAttributes } from 'js-cookie'
import BookRepository from '~/domain/Book/BookRepository'
// import { User } from "../../server/services/v1/users/users.interface";

// todo: context?
interface StorageCookieOptions extends CookieAttributes {
  cookie: {
    prefix: string
    options?: StorageCookieOptions
  }
}
interface Storage {
  setUniversal(key: string, value: any, isJson?: boolean): string
  getUniversal(key: string, isJson?: boolean): any
  syncUniversal(key: string, defaultValue: any, isJson?: boolean): any
  // Local State
  setState(key: string, val: any): string
  getState(key: string): string
  watchState(key: string, handler: (newValue: any) => void)
  // Cookies
  setCookie(key: string, val: any, options?: StorageCookieOptions)
  getCookie(key: string, isJson?: boolean): any
  // Local Storage
  setLocalStorage(key: string, val: any, isJson?: boolean)
  getLocalStorage(key: string, isJson?: boolean): any
}

interface Auth<T = any> {
  ctx: any
  $state: any // todo: type this
  $storage: Storage
  user: Partial<T>
  loggedIn: boolean
  loginWith(strategyName: string, ...args): Promise<any>
  login(...args): Promise<never>
  logout(): Promise<never>
  fetchUser(): Promise<never>
  fetchUserOnce(): Promise<never>
  hasScope(scopeName: string): boolean
  setToken(strategyName: string, token?: string): string
  syncToken(strategyName: string): string
  onError(handler: (error: Error, name: string, endpoint: any) => void)
  setUser(user?: Partial<T>)
  reset(): Promise<never>
  redirect(name: string)
}

declare module 'vue/types/options' {
  interface ComponentOptions<V extends Vue> {
    auth?: boolean
  }
}

declare module 'vue/types/vue' {
  import UserRepository from '~/domain/User/UserRepository'

  import BookshelfRepository from '~/domain/Bookshelf/BookshelfRepository'

  interface Vue {
    $auth: Auth<Any>
    close(): any // buefy
    $userRepository: UserRepository
    $bookRepository: BookRepository
    $bookshelfRepository: BookshelfRepository
  }
}

declare module 'axios' {
  export interface AxiosResponse<T = any> extends Promise<T> {}
}
