<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Amenities;
use App\Models\PropertyType;
use Illuminate\Http\Request;

class PropertyTypeController extends Controller
{
    public function AllType()
    {
        $types = PropertyType::latest()->get();

        return view('backend.type.all_type' , compact('types'));
    } //End method

    public function AddType()
    {
        return view('backend.type.add_type');
    } //End method

    public function StoreType(Request $request)
    {
        //validation
        $request->validate([
            'type_name' => 'required|unique:property_types|max:200',
            'type_icon' => 'required'
        ]);

        PropertyType::insert([
            'type_name' => $request->type_name,
            'type_icon' => $request->type_icon,

        ]);

        $notification = [
            'message'       => 'Property type created successfully',
            'alert-type'    => 'success'
        ];

        return redirect()->route('all.type')->with($notification);

    } //End method

    public function EditType($id)
    {
        $type = PropertyType::findOrFail($id);

        return view('backend.type.edit_type' , compact('type'));
    } //End method

    public function UpdateType(Request $request)
    {

        $pid = $request->id;

        PropertyType::findOrFail($pid)->update([
            'type_name' => $request->type_name,
            'type_icon' => $request->type_icon,

        ]);

        $notification = [
            'message'       => 'Property type updated successfully',
            'alert-type'    => 'success'
        ];

        return redirect()->route('all.type')->with($notification);

    } //End method

    public function DeleteType($id)
    {
        PropertyType::findOrFail($id)->delete();

        $notification = [
            'message'       => 'Property type deleted successfully',
            'alert-type'    => 'success'
        ];

        return redirect()->route('all.type')->with($notification);
    } //End method


    /////////// Amenities All method
    public function AllAmenitie()
    {
        $amenities = Amenities::latest()->get();

        return view('backend.amenities.all_amenities' , compact('amenities'));
    } //End method

    public function AddAmenitie()
    {
        return view('backend.amenities.add_amenities');
    } //End method

    public function StoreAmenitie(Request $request)
    {
        //validation
        $request->validate([
            'amenities_name' => 'required|unique:amenities|max:200',
        ]);

        Amenities::insert([
            'amenities_name' => $request->amenities_name,

        ]);

        $notification = [
            'message'       => 'Amenities created successfully',
            'alert-type'    => 'success'
        ];

        return redirect()->route('all.amenitie')->with($notification);

    } //End method

    public function EditAmenitie($id)
    {
        $amenities = Amenities::findOrFail($id);

        return view('backend.amenities.edit_amenities' , compact('amenities'));
    } //End method

    public function UpdateAmenitie(Request $request)
    {

        $ame_id = $request->id;

        Amenities::findOrFail($ame_id)->update([
            'amenities_name' => $request->amenities_name,

        ]);

        $notification = [
            'message'       => 'Amenities updated successfully',
            'alert-type'    => 'success'
        ];

        return redirect()->route('all.amenitie')->with($notification);

    } //End method

    public function DeleteAmenitie($id)
    {
        Amenities::findOrFail($id)->delete();

        $notification = [
            'message'       => 'Amenitie deleted successfully',
            'alert-type'    => 'success'
        ];

        return redirect()->route('all.amenitie')->with($notification);
    } //End method



}
