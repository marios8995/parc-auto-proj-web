import enum
from sqlalchemy import Column, Integer, Float, String, Boolean, DateTime, ForeignKey, Enum
from sqlalchemy.orm import declarative_base, relationship
from sqlalchemy.sql import func

Base = declarative_base()

# ================= ENUMS =================
class TipAsigurare(str, enum.Enum):
    RCA = "RCA"
    CASCO = "CASCO"

class SezonAnvelopa(str, enum.Enum):
    VARA = "Vara"
    IARNA = "Iarna"
    ALL_SEASON = "All-Season"

class UserRole(str, enum.Enum):
    ADMIN = "Admin"
    USER = "User"

# ================= MODELE =================

class Car(Base):
    __tablename__ = 'cars'

    id = Column(Integer, primary_key=True, index=True)
    owner_id = Column(Integer, ForeignKey('owners.id'), nullable=True)

    nr_inmatriculare = Column(String(20), unique=True, index=True, nullable=False)
    serie_sasiu = Column(String(50), unique=True, nullable=False)
    kilometraj = Column(Float, default=0.0)
    status = Column(String(20), default="activ") # ex: activ, in_service, inactiv
    data_expirare_itp = Column(DateTime)

    marca = Column(String(50))
    model = Column(String(50))
    an_fabricatie = Column(Integer)
    tip_caroserie = Column(String(50))
    tip_combustibil = Column(String(50))
    numar_locuri = Column(Integer)
    culoare = Column(String(30))
    categorie = Column(String(30))
    capacitate_cilindrica = Column(Float)
    putere = Column(Float)

    pret = Column(Float)
    disponibil = Column(Boolean, default=True)

    created_at = Column(DateTime(timezone=True), server_default=func.now())
    updated_at = Column(DateTime(timezone=True), server_default=func.now(), onupdate=func.now())

    drivers_history = relationship("DriverCarAssociation", back_populates="car")
    service_records = relationship("ManagementService", back_populates="car")
    asigurari = relationship("Asigurare", back_populates="car")
    viniete = relationship("Vinieta", back_populates="car")
    anvelope = relationship("Anvelopa", back_populates="car")
    owner = relationship("Owner", back_populates="cars")

class Driver(Base):
    __tablename__ = 'drivers'

    id = Column(Integer, primary_key=True, index=True)
    nume_complet = Column(String(100), nullable=False)
    telefon = Column(String(20), unique=True)
    cnp = Column(String(13), unique=True)
    numar_permis = Column(String(50), unique=True)
    data_expirare_permis = Column(DateTime)

    cars_history = relationship("DriverCarAssociation", back_populates="driver")

class DriverCarAssociation(Base):
    __tablename__ = 'driver_car_association'

    id = Column(Integer, primary_key=True, index=True)
    driver_id = Column(Integer, ForeignKey('drivers.id'), nullable=False)
    car_id = Column(Integer, ForeignKey('cars.id'), nullable=False)
    data_preluare = Column(DateTime(timezone=True), server_default=func.now())
    data_predare = Column(DateTime(timezone=True), nullable=True)

    driver = relationship("Driver", back_populates="cars_history")
    car = relationship("Car", back_populates="drivers_history")

class Owner(Base):
    __tablename__ = 'owners'

    id = Column(Integer, primary_key=True, index=True)
    nume = Column(String(100), nullable=False, index=True) # Ex: "Porsche Leasing IFN" sau "Ion Popescu"
    tip = Column(String(50)) # Ex: "Companie Leasing", "Persoana Fizica", "Proprie"
    cui_cnp = Column(String(20), unique=True) # CUI pt firme, CNP pt persoane
    adresa = Column(String(200))
    telefon_contact = Column(String(20))
    email_contact = Column(String(100))

    cars = relationship("Car", back_populates="owner")

class ManagementService(Base):
    __tablename__ = 'management_services'

    id = Column(Integer, primary_key=True, index=True)
    car_id = Column(Integer, ForeignKey('cars.id'), nullable=False)

    data_intrare = Column(DateTime(timezone=True), server_default=func.now())
    data_iesire = Column(DateTime(timezone=True))
    nume_serviciu = Column(String(100))
    descriere_lucrare = Column(String(255))
    cost_total = Column(Float)
    kilometraj_la_serviciu = Column(Float)

    car = relationship("Car", back_populates="service_records")

class Asigurare(Base):
    __tablename__ = 'asigurari'

    id = Column(Integer, primary_key=True, index=True)
    car_id = Column(Integer, ForeignKey('cars.id'), nullable=False)

    tip = Column(Enum(TipAsigurare), nullable=False)
    companie = Column(String(100))
    data_inceput = Column(DateTime(timezone=True), server_default=func.now())
    data_expirare = Column(DateTime(timezone=True), nullable=False)
    cost = Column(Float)

    car = relationship("Car", back_populates="asigurari")

class Vinieta(Base):
    __tablename__ = 'viniete'

    id = Column(Integer, primary_key=True, index=True)
    car_id = Column(Integer, ForeignKey('cars.id'), nullable=False)

    tara = Column(String(10)) # ex: RO, HU
    data_inceput = Column(DateTime(timezone=True), server_default=func.now())
    data_expirare = Column(DateTime(timezone=True), nullable=False)
    cost = Column(Float)

    car = relationship("Car", back_populates="viniete")

class Anvelopa(Base):
    __tablename__ = 'anvelopa'

    id = Column(Integer, primary_key=True, index=True)
    car_id = Column(Integer, ForeignKey('cars.id'), nullable=True) # Poate fi in depozit

    sezon = Column(Enum(SezonAnvelopa), nullable=False)
    marca = Column(String(50))
    dimensiuni = Column(String(20)) # ex: 205/55 R16
    stare_uzura = Column(String(50))
    locatie = Column(String(100)) # pe masina / depozit

    car = relationship("Car", back_populates="anvelope")

class Accounts(Base):
    __tablename__ = 'accounts'

    id = Column(Integer, primary_key=True, index=True)
    username = Column(String(50), unique=True, index=True, nullable=False)
    email = Column(String(100), unique=True, index=True, nullable=False)
    hashed_password = Column(String(255), nullable=False)
    is_active = Column(Boolean, default=True)
    role = Column(Enum(UserRole), default=UserRole.USER)

    created_at = Column(DateTime(timezone=True), server_default=func.now())
    updated_at = Column(DateTime(timezone=True), server_default=func.now(), onupdate=func.now())

class Notifications(Base):
    __tablename__ = 'notifications'

    id = Column(Integer, primary_key=True, index=True)
    title = Column(String(100))
    message = Column(String(255))
    timestamp = Column(DateTime(timezone=True), server_default=func.now())
    read = Column(Boolean, default=False)
    type = Column(String(50)) # ex: ITP_EXPIRA
