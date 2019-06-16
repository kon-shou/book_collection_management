import _ from 'lodash'
import { AxiosInstance } from 'axios'
import Book from '~/domain/Book/Book'
import User from '~/domain/User/User'
import Bookshelf from '~/domain/Bookshelf/Bookshelf'

export default class BookRepository {
  private axios: AxiosInstance

  constructor(axios: AxiosInstance) {
    this.axios = axios
  }

  public async create(
    title: string,
    totalPage: number,
    bookshelf: Bookshelf
  ): Promise<Book> {
    const response = await this.axios.post('/book/register', {
      title: title,
      total_page: totalPage,
      bookshelf_id: bookshelf.id
    })
    return new Book(response.data)
  }

  // Userが借りているBookの一覧
  public async findAllBooksByBorrowUser(user: User): Promise<Book[]> {
    const response = await this.axios.get(`/user/${user.id}/books/borrow`)
    return _.map(response.data, bookData => new Book(bookData))
  }

  // Bookshelfに所属してるBookの一覧
  public async findAllBooksByBookshelf(bookshelf: Bookshelf): Promise<Book[]> {
    const response = await this.axios.get(`/bookshelf/${bookshelf.id}/books`)
    return _.map(response.data, bookData => new Book(bookData))
  }

  public async startBorrow(book: Book, user: User) {
    await this.axios.put(`/book/${book.id}/borrow/start`, {
      user_id: user.id
    })
  }

  public async endBorrow(book: Book, user: User) {
    await this.axios.put(`/book/${book.id}/borrow/end`, {
      user_id: user.id
    })
  }
}
