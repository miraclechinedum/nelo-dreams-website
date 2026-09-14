<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TeamMemberRequest;
use App\Models\TeamMember;
use App\Support\MediaStorage;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class TeamMemberController extends Controller
{
    public function index(): View
    {
        return view('admin.team.index', [
            'members' => TeamMember::ordered()->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.team.create', [
            'member' => new TeamMember([
                'is_active' => true,
                'sort_order' => (int) TeamMember::max('sort_order') + 1,
            ]),
            'uploadLimitMb' => MediaStorage::serverLimitMb(),
        ]);
    }

    public function store(TeamMemberRequest $request): RedirectResponse
    {
        TeamMember::create($request->safe()->except('photo') + [
            'photo' => $request->hasFile('photo')
                ? MediaStorage::store($request->file('photo'))
                : null,
        ]);

        return redirect()
            ->route('admin.team.index')
            ->with('status', 'Team member added.');
    }

    public function edit(TeamMember $team): View
    {
        return view('admin.team.edit', [
            'member' => $team,
            'uploadLimitMb' => MediaStorage::serverLimitMb(),
        ]);
    }

    public function update(TeamMemberRequest $request, TeamMember $team): RedirectResponse
    {
        $team->update($request->safe()->except('photo') + [
            'photo' => MediaStorage::replace($request->file('photo'), $team->photo),
        ]);

        return redirect()
            ->route('admin.team.index')
            ->with('status', 'Team member updated.');
    }

    public function destroy(TeamMember $team): RedirectResponse
    {
        MediaStorage::delete($team->photo);
        $team->delete();

        return redirect()
            ->route('admin.team.index')
            ->with('status', 'Team member removed.');
    }

    /** Show / hide someone without opening the full form. */
    public function toggle(TeamMember $team): RedirectResponse
    {
        $team->update(['is_active' => ! $team->is_active]);

        return back()->with('status', $team->is_active
            ? $team->name.' is now showing on the website.'
            : $team->name.' is hidden from the website.');
    }
}
