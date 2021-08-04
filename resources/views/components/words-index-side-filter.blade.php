<form
  id="filter"
  method="GET"
  data-where="@if ($where != null){{ json_encode($where, JSON_UNESCAPED_UNICODE) }}@else[]@endif"
  x-data="filter"
  @submit.prevent="submit"
>
  <input type="hidden" name="page" value="{{ $page }}" id="pageInput" />
  <input type="hidden" name="where[]" x-model="newFilter" id="newFilterInput" x-bind:readOnly="!newFilter" />

  <template x-for="filter in filters">
    <input type="hidden" name="where[]" x-model="filter" />
  </template>

  <template x-for="(filter, index) in filters">
    <div class="card mb-4">
      <div class="card-header d-flex align-items-center justify-content-between">
        <span x-text="filter[0]"></span>

        <button
          type="button"
          class="btn-close text-reset"
          x-on:click="handleRemoveFilter(index)"
        ></button>
      </div>

      <div class="card-body">
        <select class="form-select mb-2" x-model="filter[0]">
          <option value="">Sütun</option>

          <template x-for="column in whereColumns">
            <option x-text="column" x-bind:selected="column === filter[0]"></option>
          </template>
        </select>

        <select class="form-select mb-2" x-model="filter[1]">
          <option value="">Operatör</option>

          <template x-for="operator in whereOperators">
            <option x-text="operator" x-bind:selected="operator === filter[1]"></option>
          </template>
        </select>

        <input class="form-control" x-model="filter[2]" />
      </div>
    </div>
  </template>

  <div class="card mb-4">
    <div class="card-header">Süzgeç Ekle</div>

    <div class="card-body">
      <select class="form-select mb-2" x-model="newFilterColumn">
        <option value="">Sütun</option>

        <template x-for="column in whereColumns">
          <option x-text="column" x-bind:selected="column === newFilterColumn"></option>
        </template>
      </select>

      <select class="form-select mb-2" x-model="newFilterOperator">
        <option value="">Operatör</option>

        <template x-for="operator in whereOperators">
          <option x-text="operator" x-bind:selected="operator === newFilterOperator"></option>
        </template>
      </select>

      <input class="form-control" x-model="newFilterValue" />
    </div>
  </div>

  <div class="d-grid px-2">
    <button
      type="submit"
      class="btn btn-primary btn-lg"
    >Süzgeçle</button>
  </div>

  <div class="d-grid px-4 mt-2">
    <a class="btn btn-light" href="{{ url()->current() }}">Sıfırla</a>
  </div>
</form>
