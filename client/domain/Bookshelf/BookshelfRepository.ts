import { AxiosInstance } from 'axios'
import User from '~/domain/User/User'
import Bookshelf from '~/domain/Bookshelf/Bookshelf'

export default class BookshelfRepository {
  private axios: AxiosInstance

  constructor(axios: AxiosInstance) {
    this.axios = axios
  }

  public async createPersonalBookshelfByUser(user: User): Promise<Bookshelf> {
    const response = await this.axios.post('/bookshelf/create/personal', {
      user_id: user.id
    })
    return new Bookshelf(response.data)
  }

  public async findPersonalBookshelfByUser(user: User): Promise<Bookshelf> {
    const response = await this.axios.get(`/user/${user.id}/bookshelf/personal`)
    return new Bookshelf(response.data)
  }
}
