import _ from 'lodash'

export default class Book {
  constructor(protected properties: { [key: string]: any }) {}

  get id(): string {
    return _.get(this.properties, 'id')
  }

  get title(): string {
    return _.get(this.properties, 'title')
  }

  get readPage(): number {
    return _.get(this.properties, 'read_page')
  }

  get totalPage(): number {
    return _.get(this.properties, 'total_page')
  }

  get isBorrowed(): boolean {
    return _.get(this.properties, 'is_borrowed')
  }
}
