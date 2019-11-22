<?php

namespace App\Http\Controllers\Auth;

use App\Achievements\UserMade1000Invites;
use App\Achievements\UserMade100Invites;
use App\Achievements\UserMade200Invites;
use App\Achievements\UserMade300Invites;
use App\Achievements\UserMade400Invites;
use App\Achievements\UserMade500Invites;
use App\Achievements\UserMade50Invites;
use App\Achievements\UserMade600Invites;
use App\Achievements\UserMade700Invites;
use App\Achievements\UserMade800Invites;
use App\Achievements\UserMade900Invites;
use App\Achievements\UserMadeFirstInvite;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\InvitationRequest;
use App\Mail\AccountThanksActivation;
use App\Models\Invitation;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class InvitationController extends Controller
{
    protected $signup, $invite;

    public function __construct()
    {
        $this->middleware('guest');
        $this->signup = setting('points_signup');
        $this->invite = setting('points_invite');
    }

    public function code(string $code)
    {
        $invitation = Invitation::where('code', '=', $code)->first();

        if ($invitation) {
            return view('auth.invitation', compact('code'));
        } else {
            return view('auth.activation')->with('warning',  'Codigo de convite invalido ou expirado');
        }
    }

    public function register(InvitationRequest $request)
    {
        if ($request->isMethod('post')) {
            $code = $request->input('code');
            $invitation = Invitation::where('code', '=', $code)->first();

            $original_code = $invitation->code;

            if (!$invitation) {
                return view('auth.activation', compact('original_code'))->with('warning', 'Não altere o código de convite!')->withInput();
            }

            //Points
            $signup = $this->signup;
            $invite = $this->invite;

            //Adicionar usuario convidado ao banco
            $user = new User();
            $user->role_id = 1;
            $user->username = $request->input('username');
            $user->email = $invitation->email;
            $user->password = Hash::make($request->input('password'));
            $user->status = 1;
            $user->mood_id = 1;
            $user->state_id = 25;
            $user->invites += 2;
            $user->points += $signup + $invite;
            $user->experience += $signup + $invite;
            $user->passkey = md5_gen();
            $user->birthday = Carbon::today();
            $user->activated_at = Carbon::today();
            $user->save();

            //send thank you email
            Mail::to($invitation->email)->send(new AccountThanksActivation());

            //update the invitation
            $invitation->accepted_by = $user->id;
            $invitation->code = null;
            $invitation->is_accepted = true;
            $invitation->expires_on = null;
            $invitation->accepted_at = now();
            $invitation->save();

            //Send points to friend whos have invited
            $friend = User::where('id', '=', $invitation->user_id)->first();
            $friend->invites += 2;
            $friend->points += $signup + $invite;
            $friend->experience += $signup + $invite;
            $friend->save();

            // Achievements
            $friend->unlock(new UserMadeFirstInvite(), 1);
            $friend->addProgress(new UserMade50Invites(), 1);
            $friend->addProgress(new UserMade100Invites(), 1);
            $friend->addProgress(new UserMade200Invites(), 1);
            $friend->addProgress(new UserMade300Invites(), 1);
            $friend->addProgress(new UserMade400Invites(), 1);
            $friend->addProgress(new UserMade500Invites(), 1);
            $friend->addProgress(new UserMade600Invites(), 1);
            $friend->addProgress(new UserMade700Invites(), 1);
            $friend->addProgress(new UserMade800Invites(), 1);
            $friend->addProgress(new UserMade900Invites(), 1);
            $friend->addProgress(new UserMade1000Invites(), 1);

            return view('auth.activation')
                ->with('info', 'Conta criada e ativada com sucesso, agora você pode fazer login.');
        } else {
            return redirect()->to('login');
        }
    }
}
