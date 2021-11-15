<div class="learning--group--select--wrapper" data-vvveb-disabled>
    <form action="/questions-form" method="POST">
        @method("POST")
        @csrf
        <div class="form-group">
            <label for="exampleFormControlInput1">Jūsų el.pašto adresas</label>
            <input type="email" class="form-control" name="email" id="exampleFormControlInput1" placeholder="name@example.com" required>
        </div>
        <div class="form-group">
            <label for="exampleFormControlSelect1">Kokios jūsų lietuvių kalbos žinios?</label>
            <select class="form-control" name="language_level" id="exampleFormControlSelect1" required>
                <option value="Nekalbu ir nesuprantu">Nekalbu ir nesuprantu</option>
                <option value="Kažkiek kalbu pavieniais žodžiais">Kažkiek kalbu pavieniais žodžiais</option>
                <option value="Rišliai kalbu">Rišliai kalbu</option>
            </select>
        </div>
        <div class="form-group" >
            <fieldset>
                <legend>Kokiomis dienomis norėtumėte, kad vyktų pamokos?</legend>
                <input type="checkbox" name="week_days[]" id="track" value="Pirmadieniais" /><label for="track">Pirmadieniais</label><br />
                <input type="checkbox" name="week_days[]" id="event" value="Antradieniais"  /><label for="event">Antradieniais</label><br />
                <input type="checkbox" name="week_days[]" id="message" value="Trečiadieniais" /><label for="message">Trečiadieniais</label><br />
                <input type="checkbox" name="week_days[]" id="message" value="Ketvirtadieniais" /><label for="message">Ketvirtadieniais</label><br />
                <input type="checkbox" name="week_days[]" id="message" value="Penktadieniais" /><label for="message">Penktadieniais</label><br />
                <input type="checkbox" name="week_days[]" id="message" value="Šeštadieniais" /><label for="message">Šeštadieniais</label><br />
                <input type="checkbox" name="week_days[]" id="message" value="Sekmadieniais" /><label for="message">Sekmadieniais</label><br />
            </fieldset>
        </div>
        <div class="form-group" style="margin-top: 15px;">
            <label for="exampleFormControlSelect1" class="mt-3">Kiek kartų per savaitę norėtumėte mokytis?</label>
            <select required class="form-control" name="times_per_week" id="exampleFormControlSelect1" >
                <option value="Vieną kartą">Vieną kartą</option>
                <option value="Du kartus">Du kartus</option>
            </select>
        </div>

        <div class="form-group">
            <label for="exampleFormControlTextarea1">Papildomi komentarai/klausimai</label>
            <textarea class="form-control" name="comment" id="exampleFormControlTextarea1" rows="3"></textarea>
            <button type="submit" class="btn btn-primary">Siųsti</button>
        </div>
    </form>
</div>