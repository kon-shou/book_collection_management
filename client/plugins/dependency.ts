import BookRepository from '~/domain/Book/BookRepository'
import UserRepository from '~/domain/User/UserRepository'
import BookshelfRepository from '~/domain/Bookshelf/BookshelfRepository'

export default (context, inject) => {
  const userRepository = new UserRepository(context.$axios)
  const bookRepository = new BookRepository(context.$axios)
  const bookshelfRepository = new BookshelfRepository(context.$axios)

  inject('userRepository', userRepository)
  inject('bookRepository', bookRepository)
  inject('bookshelfRepository', bookshelfRepository)
}
