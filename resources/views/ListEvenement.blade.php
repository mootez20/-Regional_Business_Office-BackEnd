<h1>list of event</h1>




<table border="1">
    <tr>
        <td>nom</td>
        <td>titre</td>
        <td>description</td>
        <td>date_debut</td>
        <td>date_fin</td>
        <td>affiche</td>
        <td>lieu</td>
        <td>prix</td>
        <td>image</td>
    </tr>
    @foreach ($events as $event)
    <tr>
        <td>{{$event->nom}}</td>
        <td>{{$event->titre}}</td>
        <td>{{$event->description}}</td>
        <td>{{$event->date_debut}}</td>
        <td>{{$event->date_fin}}</td>
        <td>{{$event->affiche}}</td>
        <td>{{$event->lieu}}</td>
        <td>{{$event->prix}}</td>
        <td>{{$event->image}}</td>
    </tr>
    @endforeach
</table>

<span>
    {{$events->links()}} 
</span>
<style>
    .w-5{
        display:none;
    }
</style>