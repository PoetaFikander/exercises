<select class="form-select my-1 me-sm-2 w-auto" id="for_week" name="for_week" data-toggle="h_r_c_for_week">
    @foreach($weeks as $week)
        <option
            data-from="{{ $week->w_start }}"
            value="{{ $week->w_start }}"
            @if($week->w_no == $ad->weekDays->w_no) selected @endif
        >
            {{ $week->w_start . ' - ' . $week->w_end }}
        </option>
    @endforeach
</select>

