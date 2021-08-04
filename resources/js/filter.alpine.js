const filter = () => {
  return {
    orderColumns: [
      'id',
      'json->madde',
      'json->lisan_kodu',
      'json->lisan',
    ],

    whereColumns: [
      'json->madde',
      'json->lisan_kodu',
      'json->lisan',
      'json->birlesikler',
      'json->anlamlarListe',
    ],

    whereOperators: [
      "=",
      "!=",
      "like",
      "not like",
      "ilike",
      "not ilike",
      "rlike",
      "not rlike",
      "regexp",
      "not regexp",
      // "<",
      // ">",
      // "<=",
      // ">=",
      // "<>",
      // "<=>",
      // "like binary",
      // "&",
      // "|",
      // "^",
      // "<<",
      // ">>",
      // "~",
      // "~*",
      // "!~",
      // "!~*",
      // "similar to",
      // "not similar to",
      // "~~*",
      // "!~~*",
    ],

    filters: [],

    newFilterColumn: '',
    newFilterOperator: '',
    newFilterValue: '',

    newFilter: function () {
      if (this.newFilterColumn === '' || this.newFilterOperator === '' || this.newFilterValue === '') {
        return null
      }

      return this.newFilterColumn + ',' + this.newFilterOperator + ',' + this.newFilterValue
    },

    init() {
      const where = JSON.parse(document.querySelector('#filter').dataset.where)

      this.filters = where.map((w) => w.split(','))
    },

    handleRemoveFilter (index) {
      const nextFilters = [...this.filters]

      nextFilters.splice(index, 1)

      this.filters = nextFilters
    },

    submit () {
      const pageInput = document.querySelector('#pageInput')
      const newFilterInput = document.querySelector('#newFilterInput')

      pageInput.parentNode.removeChild(pageInput)

      if (!this.newFilter()) {
        newFilterInput.parentNode.removeChild(newFilterInput)
      }

      this.$nextTick(() => {
        this.$el.submit()
      })
    },
  }
};

module.exports = filter
