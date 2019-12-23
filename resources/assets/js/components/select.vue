
<script>
import Select2 from 'select2';
export default {
  props: ['options', 'value', 'placeholder', 'allowclear'],
  template: '<select class="form-control"><slot></slot></select>',
  mounted: function () {
    var vm = this
    $(this.$el)
      // init select2
      .select2({ data: this.options, placeholder: this.placeholder, allowClear: this.allowclear})
      .val(this.value)
      .trigger('change')
      // emit event on change.
      .on('change', function () {
        vm.$emit('input', this.value)
      })
  },
  watch: {
    value: function (value) {
      // console.log('watch.value: ' + value);
      // update value
     $(this.$el).val(value)
      // .trigger('change')
    },
    options: function (options) {
      // console.log('watch.options: ' + options);
      // update options
      $(this.$el).empty().trigger('change')
      .select2({ data: options, placeholder: this.placeholder, allowClear: this.allowclear })
        // .val([])
    }
  },
  destroyed: function () {
    $(this.$el).off().select2('destroy')
  }
}
</script>
<style>
  select{
    width: 100%;
  }
</style>
