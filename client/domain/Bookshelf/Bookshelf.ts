import _ from 'lodash'

export default class Bookshelf {
  constructor(protected properties: { [key: string]: any }) {}

  get id(): string {
    return _.get(this.properties, 'id')
  }

  get ownerType(): string {
    return _.get(this.properties, 'owner_type')
  }

  get ownerId(): string {
    return _.get(this.properties, 'owner_id')
  }
}
