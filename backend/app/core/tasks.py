from apscheduler.schedulers.background import BackgroundScheduler
from app.database import Session
from app.models.models import Notifications
from app.api.cars import get_itp_in_prag_de_expirare
from app.api.drivers import get_permise_in_prag_de_expirare
from app.api.asigurari import get_asigurari_in_prag_de_expirare
from app.api.viniete import get_viniete_in_prag_de_expirare
from app.api.anvelope import get_anvelope_de_schimbat

def adauga_notificare(db, title: str, message: str, notif_type: str):
    existenta = db.query(Notifications).filter(
        Notifications.type == notif_type,
        Notifications.message == message,
        Notifications.read == False
    ).first()
    if not existenta:
        noua_notificare = Notifications(title=title, message=message, type=notif_type)
        db.add(noua_notificare)

def ruleaza_verificari_zilnice():
    print("[CRON JOB] Se ruleaza verificarile zilnice de flota...")
    db = Session()
    try:
        masini_itp = get_itp_in_prag_de_expirare(db, zile_avertizare=30)
        for masina in masini_itp:
            adauga_notificare(
                db,
                "Avertizare ITP",
                f"ITP-ul masinii {masina.nr_inmatriculare} expira curand sau a expirat!",
                "ITP_EXPIRA"
            )

        soferi = get_permise_in_prag_de_expirare(db, zile_avertizare=30)
        for sofer in soferi:
            adauga_notificare(
                db,
                "Avertizare Permis",
                f"Permisul șoferului {sofer.nume_complet} expiră curând!",
                "PERMIS_EXPIRA"
            )

        asigurari = get_asigurari_in_prag_de_expirare(db, zile_avertizare=15)
        for asig in asigurari:
            adauga_notificare(
                db,
                "Avertizare Asigurare",
                f"Polița {asig.tip.value} pentru mașina {asig.car.nr_inmatriculare} expiră curând!",
                "ASIGURARE_EXPIRA"
            )

        viniete = get_viniete_in_prag_de_expirare(db, zile_avertizare=7)
        for vin in viniete:
            adauga_notificare(
                db,
                "Avertizare Vinietă",
                f"Vinieta pentru {vin.tara} a mașinii {vin.car.nr_inmatriculare} expiră curând!",
                "VINIETA_EXPIRA"
            )

        anvelope = get_anvelope_de_schimbat(db)
        for anv in anvelope:
            masina_text = f"pe mașina {anv.car.nr_inmatriculare}" if anv.car else "în depozit"
            adauga_notificare(
                db,
                "Mentenanță Anvelope",
                f"Anvelopa ({anv.dimensiuni}) aflată {masina_text} necesită schimbare (Status: {anv.stare_uzura}).",
                "ANVELOPA_UZATA")

        db.commit()
        print("[CRON JOB] Verificările s-au încheiat cu succes.")

    except Exception as e:
        print(f"[CRON JOB] Eroare la rularea task-urilor: {e}")
    finally:
        db.close()

scheduler = BackgroundScheduler()

def start_scheduler():
    scheduler.add_job(ruleaza_verificari_zilnice, 'cron', hour=8, minute=0)
    scheduler.start()
    print("Systemul de CRON Jobs a fost pornit!")
