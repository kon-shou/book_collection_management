import _ from 'lodash'

export default class User {
  constructor(protected properties: { [key: string]: any }) {}

  get id(): string {
    return _.get(this.properties, 'id')
  }

  get name(): string {
    return _.get(this.properties, 'name')
  }

  get email(): string {
    return _.get(this.properties, 'email')
  }
}
