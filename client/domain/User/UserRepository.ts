// import _ from 'lodash'
import { AxiosInstance } from 'axios'
import User from '~/domain/User/User'

export default class UserRepository {
  private axios: AxiosInstance

  constructor(axios: AxiosInstance) {
    this.axios = axios
  }

  public async find(userId: number): Promise<User> {
    const response = await this.axios.get(`/user/${userId}`)
    return new User(response.data)
  }

  public async create(value: {
    name: string
    email: string
    password: string
  }): Promise<User> {
    const response = await this.axios.post('/auth/register', {
      name: value.name,
      email: value.email,
      password: value.password
    })
    return new User(response.data)
  }
}
