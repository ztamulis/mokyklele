<div class="learning--group--select--wrapper" data-vvveb-disabled>
    <form action="/questions-form" method="POST">
        @method("POST")
        @csrf
        <div class="form-group">
            <label for="exampleFormControlInput1">Elektroninis paštas</label>
            <input type="email" class="form-control" name="email" id="exampleFormControlInput1" placeholder="name@example.com">
        </div>
        <div class="form-group">
            <label for="exampleFormControlSelect1">Kokios jūsų lietuvių kalbos žinios?</label>
            <select class="form-control" name="language_level" id="exampleFormControlSelect1">
                <option value="Nekalbu ir nesuprantu">Nekalbu ir nesuprantu</option>
                <option value="Kažkiek kalbu pavieniais žodžiais">Kažkiek kalbu pavieniais žodžiais</option>
                <option value="Rišliai kalbu">Rišliai kalbu</option>
            </select>
        </div>
        <div class="form-group">
            <label for="exampleFormControlSelect2">Kokiomis dienomis norėtumėte, kad vyktų pamokos?</label>
            <select multiple class="form-control" name="week_days[]" id="exampleFormControlSelect2">
                <option value="Pirmadieniais">Pirmadieniais</option>
                <option value="Antradieniais">Antradieniais</option>
                <option value="Trečiadieniais">Trečiadieniais</option>
                <option value="Ketvirtadieniais">Ketvirtadieniais</option>
                <option value="Penktadieniais">Penktadieniais</option>
                <option value="Savaitgaliais">Savaitgaliais</option>
            </select>
        </div>
        <div class="form-group">
            <label for="exampleFormControlSelect1">Kiek kartų per savaitę norėtumėte mokytis?</label>
            <select class="form-control" name="times_per_week" id="exampleFormControlSelect1">
                <option value="Vieną kartą">Vieną kartą</option>
                <option value="Du kartus">Du kartus</option>
                <option value="Rišliai kalbu">Rišliai kalbu</option>
            </select>
        </div>

        <div class="form-group">
            <label for="exampleFormControlTextarea1">Papildomi komentarai/klausimai</label>
            <textarea class="form-control" name="comment" id="exampleFormControlTextarea1" rows="3"></textarea>
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>